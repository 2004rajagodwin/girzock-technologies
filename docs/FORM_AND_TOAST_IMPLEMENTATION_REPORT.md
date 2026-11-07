# Forms and Notifications Report

Date: 7 November 2026.

## Forms on the site
| Form | Where | Sends to | Message field |
|---|---|---|---|
| Project enquiry | Homepage | `contact/submit` | Required (at least 10 characters) |
| Popup enquiry | Promotional popup, all public pages | `contact/submit` (`form_type=popup`) | **Optional** |
| Contact | Contact page | `contact/submit` | Required |
| Short message form | "Get in Touch" panels on inner pages | `contact/submit` | Required |
| Job application | Career pages | `careers/apply` (full page post) | Cover letter optional; resume required |

**Required in every enquiry form:** name, email, phone and service. The short message form asks for a subject instead of a service.

The popup's optional message is enforced on both sides:
- **In the browser:** the field has no `required` attribute and is marked "(optional)".
- **On the server:** `Contact::validate` skips the message check only when `form_type` is `popup`.

Every other form still requires a message.

## One notification for every form
`GirzockToast` in `assets/js/girzock.js` gives every form the same notification.

| Situation | Toast | Shown when |
|---|---|---|
| Saved | Green, check icon: "Thank you! Your enquiry has been submitted successfully." No reference number is shown; it is still saved and appears in the admin and in the confirmation email | **Only after the server replies that the enquiry was saved** |
| Field errors | Red: "Please check the highlighted fields and try again." | Browser or server validation fails; field messages stay beside each field |
| Failure | Red: "Something went wrong. Please try again or contact us directly." | Network failure or server error; rate-limit replies keep their own message |
| Job application | The same toast style, from the server's success or error message | After the page reloads |

**Behaviour:**
- Slides and fades in at the top right on desktop, and at the bottom on phones.
- Closes after 3.5 seconds; hovering pauses it, and it has a close button.
- Updated 7 November 2026 (shorter message, no reference, 3.5 s). See `FORM_SUBMISSION_PERFORMANCE_REPORT.md` for the faster reply.
- Success toasts are announced politely (`role="status"`); errors immediately (`role="alert"`).
- The toast sits above the popup overlay. After a popup success, the popup closes 0.7 s later, so the toast stays visible.
- While sending, the button is disabled, marked busy and shows "Sending...", which prevents duplicate submissions.
- **Entered values are kept** on any failure. The form is cleared only after a confirmed save.
- With reduced motion turned on, there is no animation.

## Server protections (unchanged, retested)
| Protection | Detail |
|---|---|
| CSRF token | On every form |
| Server-side validation | Every field |
| Honeypot field | Catches automated submissions |
| Duplicate detection | Content hash |
| Rate limit | 5 enquiries per 10 minutes per connection |
| Order of work | The enquiry is saved before any email is sent |
| Email results | Recorded per recipient in `email_log`. A failed email never removes the enquiry, and the cron job retries it |

## Files
- **Script:** `assets/js/girzock.js`
- **Styles:** `assets/css/girzock.css`
- **Server:** `application/controllers/Contact.php`
- **Form view:** `application/views/frontend/partials/enquiry_form.php`
- **Popup:** `application/views/frontend/partials/promo_popup.php`

Test results are in `TESTING_REPORT.md`.
