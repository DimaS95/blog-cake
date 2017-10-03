<h1>Welcome, <?= $user['username']; ?>

              </h1>

<h1>Blog articles</h1>
<h2><a href = "/articles/add">Create Article</a></h2>
<table>
    <tr>

        <th>Title</th>
        <th>Created</th>

    </tr>

<!-- Here's where we loop through our $articles query object, printing out article info -->

    <?php foreach ($articles as $article): ?>
    <tr>

        <td>
            <?= $article->title?>
        </td>
        <td>
<?= $article->created->format(DATE_RFC850) ?>
</td>
 <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Articles','action' => 'view' ,'_full' => true, $article->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Articles', 'action' => 'edit', $article->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Articles','action' => 'delete', $article->id], ['confirm' => __('Are you sure you want to delete # {0}?', $article->id)]) ?>
                </td>

    </tr>
    <?php endforeach; ?>

</table>