<?php
    foreach ($alerts as $key => $messages) :
        foreach ($messages as $warning) :
?>
    <div class="alert <?php echo $key; ?>">
            <?php echo $warning; ?>
    </div>
<?php
        endforeach;
    endforeach;
?>