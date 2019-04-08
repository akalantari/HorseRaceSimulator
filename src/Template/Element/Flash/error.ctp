<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="animated flash alert alert-danger" onclick="this.classList.add('hidden')">
    <?= $message ?>
    <?php if(!empty($params['errors'])):?>
        <ul>
            <?php foreach($params['errors'] as $err):?>
                <li><?=$err?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
