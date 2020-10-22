<!-- File: templates/Articles/index.php -->

<h1>Articles</h1>
<p><?= $this->Html->link("Add Article", ['action' => 'add']) ?></p>
<table>
    <tr>
        <th>Title</th>
        <th>Created</th>
        <th>Action</th>
    </tr>

    <!-- Here's where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($articles as $article): ?>
        <tr>
            <td>
                <?= $this->Html->link($article->title, ['action' => 'view', $article->slug]) ?>
            </td>
            <td>
                <?= $article->created->format(DATE_RFC850) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $article->slug]) ?>
            </td>
        </tr>
    <?php endforeach; ?>

</table>
