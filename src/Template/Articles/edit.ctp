<h1>Edit Article</h1>
<?php
    echo $this->Form->create($article);
    echo $this->Form->control('title');
    echo $this->Form->textarea('body', ['rows' => '13']);
    echo $this->Form->button(__('Save Article'));
    echo $this->Form->end();
?>