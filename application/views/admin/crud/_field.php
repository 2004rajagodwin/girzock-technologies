<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* One form field. Expects $field, $values and $errors. */
$name = $field['name'];
$type = $field['type'];
$value = isset($values[$name]) ? $values[$name] : '';
$error = isset($errors[$name]) ? $errors[$name] : NULL;
$required = ! empty($field['required']);
$id = 'f-'.$name;
$describe = $error ? ' aria-invalid="true" aria-describedby="'.$id.'-error"' : '';
?>
<div class="gz-field<?= $error ? ' has-error' : '' ?>">
    <?php if ($type === 'checkbox'): ?>
    <label class="gz-check"><input type="checkbox" id="<?= $id ?>" name="<?= e($name) ?>" value="1"<?= ($value === '' ? ' checked' : ($value ? ' checked' : '')) ?>> <?= e($field['label']) ?></label>
    <?php else: ?>
    <label for="<?= $id ?>"><?= e($field['label']) ?><?= $required ? ' <span class="gz-req" aria-hidden="true">*</span>' : '' ?></label>
    <?php endif; ?>

    <?php switch ($type):
        case 'textarea': ?>
        <textarea id="<?= $id ?>" name="<?= e($name) ?>" rows="4"<?= $required ? ' required' : '' ?><?= $describe ?>><?= e($value) ?></textarea>
        <?php break;
        case 'lines': ?>
        <textarea id="<?= $id ?>" name="<?= e($name) ?>" rows="5"<?= $describe ?>><?= e($value) ?></textarea>
        <?php break;
        case 'richtext': ?>
        <div class="gz-editor" data-gz-editor>
            <div class="gz-editor-bar" role="toolbar" aria-label="Formatting">
                <button type="button" data-cmd="bold" aria-label="Bold"><b>B</b></button>
                <button type="button" data-cmd="italic" aria-label="Italic"><i>I</i></button>
                <button type="button" data-block="H2">H2</button>
                <button type="button" data-block="H3">H3</button>
                <button type="button" data-block="P">P</button>
                <button type="button" data-cmd="insertUnorderedList">List</button>
                <button type="button" data-cmd="insertOrderedList">1. List</button>
                <button type="button" data-block="BLOCKQUOTE">Quote</button>
                <button type="button" data-link>Link</button>
                <button type="button" data-image>Image</button>
                <button type="button" data-source>HTML</button>
            </div>
            <div class="gz-editor-area" contenteditable="true" role="textbox" aria-multiline="true" aria-labelledby="<?= $id ?>-label"></div>
            <textarea id="<?= $id ?>" name="<?= e($name) ?>" rows="12" hidden<?= $describe ?>><?= e($value) ?></textarea>
        </div>
        <span id="<?= $id ?>-label" hidden><?= e($field['label']) ?></span>
        <?php break;
        case 'select': ?>
        <select id="<?= $id ?>" name="<?= e($name) ?>"<?= $required ? ' required' : '' ?><?= $describe ?>>
            <?php foreach ($field['options'] as $option => $label): ?><option value="<?= e($option) ?>"<?= (string) $option === (string) $value ? ' selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?>
        </select>
        <?php break;
        case 'multiselect':
            $chosen = is_array($value) ? array_map('strval', $value) : array(); ?>
        <select id="<?= $id ?>" name="<?= e($name) ?>[]" multiple size="6">
            <?php foreach ($field['options'] as $option => $label): ?><option value="<?= e($option) ?>"<?= in_array((string) $option, $chosen, TRUE) ? ' selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?>
        </select>
        <?php break;
        case 'image': ?>
        <div class="gz-image-field" data-gz-image<?= empty($field['brand']) ? '' : ' data-gz-brand="1"' ?>>
            <img class="gz-image-preview" src="<?= e($value ? media_url($value) : '') ?>" alt=""<?= $value ? '' : ' hidden' ?>>
            <input type="hidden" id="<?= $id ?>" name="<?= e($name) ?>" value="<?= e($value) ?>">
            <input type="file" name="<?= e($name) ?>" accept=".jpg,.jpeg,.png,.webp,.gif" aria-label="Upload <?= e($field['label']) ?>">
            <div class="gz-image-actions">
                <button type="button" class="gz-btn gz-btn-ghost gz-btn-sm" data-gz-pick>Choose from library</button>
                <button type="button" class="gz-btn gz-btn-ghost gz-btn-sm" data-gz-clear<?= $value ? '' : ' hidden' ?>>Remove</button>
            </div>
        </div>
        <?php break;
        case 'gallery': ?>
        <textarea id="<?= $id ?>" name="<?= e($name) ?>" rows="4" placeholder="assets/uploads/..."<?= $describe ?> data-gz-gallery-list><?= e($value) ?></textarea>
        <div class="gz-image-actions">
            <input type="file" name="<?= e($name) ?>_files[]" multiple accept=".jpg,.jpeg,.png,.webp,.gif" aria-label="Upload images to <?= e($field['label']) ?>">
            <button type="button" class="gz-btn gz-btn-ghost gz-btn-sm" data-gz-pick-gallery>Add from library</button>
        </div>
        <?php break;
        case 'number': ?>
        <input type="number" id="<?= $id ?>" name="<?= e($name) ?>" value="<?= e($value) ?>" step="1"<?= $describe ?>>
        <?php break;
        case 'url': ?>
        <input type="url" id="<?= $id ?>" name="<?= e($name) ?>" value="<?= e($value) ?>" placeholder="https://"<?= $describe ?>>
        <?php break;
        case 'date': ?>
        <input type="date" id="<?= $id ?>" name="<?= e($name) ?>" value="<?= e($value) ?>"<?= $describe ?>>
        <?php break;
        case 'datetime': ?>
        <input type="datetime-local" id="<?= $id ?>" name="<?= e($name) ?>" value="<?= e($value ? date('Y-m-d\TH:i', strtotime($value)) : '') ?>"<?= $describe ?>>
        <?php break;
        case 'checkbox': break;
        default: ?>
        <input type="text" id="<?= $id ?>" name="<?= e($name) ?>" value="<?= e($value) ?>"<?= empty($field['max']) ? '' : ' maxlength="'.(int) $field['max'].'"' ?><?= $required ? ' required' : '' ?><?= $describe ?>>
    <?php endswitch; ?>

    <?php if ($error): ?><p class="gz-error" id="<?= $id ?>-error"><?= e($error) ?></p><?php endif; ?>
    <?php if ( ! empty($field['help'])): ?><p class="gz-help"><?= e($field['help']) ?></p><?php endif; ?>
</div>
