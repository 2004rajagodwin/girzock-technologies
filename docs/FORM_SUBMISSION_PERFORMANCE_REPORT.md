# Form Submission Performance Report

**Date:** 7 November 2026
**Forms covered:**
- the promotional popup;
- the homepage enquiry form;
- the Contact page form;
- the short message form on inner pages.

All four send to `contact/submit`. The careers application form is a normal page post with a file upload, and was not changed.

## Result

| | Before | After |
|---|---:|---:|
| Time until the visitor sees the reply, with a mail server that takes 3 s per email (median of 5) | **6,123 ms** (6,081 to 6,133) | **60 ms** (49 to 68) in the first run; **43 ms** (33 to 58) in the repeat run |
| Enquiry saved before the reply | Yes | Yes |
| Both emails sent | Yes, before the reply | Yes, after the reply. Checked 12 s later: `company=sent`, `client=sent` |

**Your own enquiries before the change:** GZ-ENQ-2026-00007 and 00008, sent through the real Gmail SMTP account, took about 13 to 14 s from saving to the second email. The email log shows the enquiry saved at 16:40:16, the company email at 16:40:23 and the client email at 16:40:30. Before the change, the visitor waited for all of that.

## What was slow

The server saved the enquiry, then sent the company email and the client email one after the other, and only then answered the browser. Each email to Gmail took several seconds, so the visitor waited for both.

## What changed

`application/controllers/Contact.php`, `reply_now()`:

1. The enquiry is checked and **saved to the database first**, as before. If saving fails, the visitor gets an error and no success message.
2. The server then **sends the reply at once**. It sets a fixed `Content-Length` and `Connection: close`, empties PHP's output buffers and turns off compression for that one response, so nothing holds the reply back. It also calls `fastcgi_finish_request()` where the server supports it.
3. It **releases the session** (`session_write_close()`), so the visitor's next page does not wait for the emails.
4. Only then does it **send the two emails**. `ignore_user_abort` keeps them going even if the visitor closes the page. The time limit for this step is 120 s.

Requests that are not AJAX, such as a browser without JavaScript, still get a normal page after the emails, as before.

## If an email fails

- Every email result is stored in `email_log`, one row per recipient. It holds `pending`, `sent`, `failed` or `skipped`, the number of attempts and the error message. Passwords never appear in the error text, and this was tested.
- **The enquiry is never lost.** It is saved before any email is attempted.
- **Retry:** open **Admin → Enquiries → (the enquiry)** and click **Resend**. Only the emails not yet sent are sent again, and duplicates are prevented by the log.
- **Automatic retry:** the deployment guide adds a cron job running `php index.php setup retry_emails` every 15 minutes.
- **The visitor's message** is the same short success message either way, because their enquiry is saved.

## Success message

- **Text:** "Thank you! Your enquiry has been submitted successfully."
- **No reference number** is shown; it stays in the admin and in the confirmation email.
- **Timing:** it closes after 3.5 s and has a close button.
- **Shown only after** the server confirms the save.
- **Same everywhere:** all four forms use the same toast.

## How it was measured

- **Script:** `t59_speed.php`, run on the **isolated test copy**. It has its own database (`girzock_test`), PHP's built-in server on port 8096, and a local mail server (`smtp_slow.php`) that waits 3 s before accepting each email. No real email was sent, and the real database was not touched.
- **What was timed:** each run gets the homepage token, then times a real popup submission with curl, end to end. It checks the reply is `ok`, checks the row is in the database, and after 12 s checks the email log.
- **Before:** measured on the code before the change, on the same setup.
- **On Apache:** PHP's built-in server was used for the measurement above. To check the same steps on Apache, which the live site uses, a temporary file under the local XAMPP Apache sent the reply the same way and then waited 5 s:
  - the reply arrived in **4 ms** in each of 5 runs;
  - the 5 s step still finished afterwards;
  - the file was deleted after the test.

## What could still slow it on the live server

Some hosts buffer PHP output or compress it on the way out, which can hold the reply until the script ends. The code already asks Apache not to compress this response. Step 8 of `PRODUCTION_DEPLOYMENT_GUIDE.md` covers the live check:
1. send one enquiry;
2. the message should appear in under a second;
3. the email log should show both emails as sent.

## Tests that cover this

The counts are in `FINAL_REGRESSION_TEST_REPORT.md`.
- Public, admin and forms suites: the enquiry is saved, both emails reach the local mail catcher, there are no duplicates on a double submit, failures are logged and Resend delivers them. These tests now wait up to 15 s for the emails, because the emails now come after the reply.
- Browser tests in Chromium, Firefox and WebKit: the toast text, no reference, auto-close and the close button.
