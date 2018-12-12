<?php foreach ($jokes as $joke): ?>
<blockquote>
    <p>
        <?= htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8') ?>

        (by <a href="mailto:<?php echo htmlspecialchars($joke['email'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($joke['name'], ENT_QUOTES, 'UTF-8'); ?>
        </a>)
        
        <form action="deletejoke.php" method="POST">
            <input type="hidden" name="id" value="<?= $joke['id'] ?>">
            <input type="submit" value="Delete">
        </form>
    </p>
</blockquote>
<?php endforeach; ?>