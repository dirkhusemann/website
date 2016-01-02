<? snippet('_header') ?>

<article>
    <header>
    <? if ($page->type() == 'parent'): ?>
        <h1><?= smartypants($page->title()) ?></h1>
        <?
        $items = $page->children()->visible();
        if($items && $items->count()):
        ?>
            <nav role="navigation">
                <a class="is-active" href="<?= $page->url() ?>"><?= smartypants($page->title()) ?></a>
                <? foreach($items as $item): ?>
                    <a<?= ($item->isOpen()) ? ' class="is-active"' : '' ?> href="<?= $item->url() ?>"><?= smartypants($item->title()) ?></a>
                <? endforeach ?>
            </nav>
        <? endif ?>

    <? elseif ($page->type() == 'child'): ?>
        <h1><?= smartypants($page->parent()->title()) ?></h1>
        <?
        $items = $page->siblings()->visible();
        if($items && $items->count()):
        ?>
            <nav role="navigation">
                <a href="<?= $page->parent()->url(); ?>"><?= smartypants($page->parent()->title()) ?></a>
                <? foreach($items as $item): ?>
                    <a<?= ($item->isOpen()) ? ' class="is-active"' : '' ?> href="<?= $item->url() ?>"><?= smartypants($item->title()) ?></a>
                <? endforeach ?>
            </nav>
        <? endif ?>
    <? endif ?>
    </header>

<? if($page->text()->isNotEmpty()): ?>
    <?= kirbytext($page->text()) ?>
<? endif ?>

<? if($page->related()->isNotEmpty()): ?>
    <? snippet('related') ?>
<? endif ?>

</article>

<? snippet('_footer') ?>
