<?php
function inputField(string $label, string $id, string $name = null, string $value = null, string $type = "text", bool $required = true, int $maxlength = null)
{
    $name ??= $id;
    $id .= "-field";
    $required = $required ? "required" : null;
    $maxlength = $maxlength != null ? "maxlength={$maxlength}" : null;

    echo "
        <div class='input-field'>
            <label for='{$id}'>{$label}:</label>
            <input id='{$id}' name='{$name}' type='{$type}' value='{$value}' {$required} {$maxlength} autocomplete='off' />
        </div>
    ";
}
?>