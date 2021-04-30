<?php
  $name = $entry[0]->name;
  $value = $entry[0]->value;


?>


<h1>Edit Entry</h1>


<form method="POST">
  
  <div>

    <div style="display: inline-block;">
      <input type="text" name="key" placeholder="label" value="<?php echo $name; ?>">
    </div>

    <div style="display: inline-block;">
      <input type="text" name="value" placeholder="value" value="<?php echo $value; ?>">
    </div>


    <input type="submit" name="submit" value="Update">

  </div>

</form>