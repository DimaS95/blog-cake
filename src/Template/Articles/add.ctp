<h1>Add Article</h1>
<?php
    echo $this->Form->create($article, array('class'=>'form-horizontal','role'=>'form','type'=>'file'));
    echo $this->Form->control('title').'<br><br>';
    echo $this->Form->textarea('body', ['rows' => '6']);
    echo $this->Form->input("image",array("type"=>"file","size"=>"45", 'error' => false,'placeholder'=>'Upload Image'));
    echo $this->Form->button(__('Save Article'));
    echo $this->Form->end();
 ?>