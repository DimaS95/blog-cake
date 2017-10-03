<h1>Author's articles</h1>

<table>
    <tr>
        <th>Title</th>
        <th>Created</th>
        <th></th>

    </tr>

<!-- Here's where we loop through our $articles query object, printing out article info -->

    <?php foreach ($articles as $article): ?>
    <tr>

        <td>
            <?= $article->title ?>
        </td>
        <td>
<?= $article->created->format(DATE_RFC850) ?>
</td>
<td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Articles','action' => 'view' ,'_full' => true, $article->id]) ?>

                </td>

    </tr>
    <?php endforeach; ?>

</table>