<nav>
    <li>
        <a <?php echo(($page == 'uno') ? 'class="active"' : 'class="ImNotActive"') ?> data-tuputamadre
            href="page1.php">page1</a>
    </li>
    <li>
        <a <?php echo(($page == 'dos') ? 'class="active"' : '') ?> href="page2.php">page2</a>
    </li>
    <li>
        <a <?php echo(($page == 'tres') ? 'class="active"' : '') ?> href="page3.php">page3</a>
    </li>
</nav>