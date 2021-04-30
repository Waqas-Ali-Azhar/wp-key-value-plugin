<?php
  
  if(empty($_GET['edit'])):

 ?>


 <h1>All Enteries</h1>
<table id="all-enteries">
  <tr>
    <td>ID</td>
    <td>Name</td>
    <td>Value</td>
    <td>Edit</td>
    <td>Delete</td>
  </tr>
  

 <?php

  foreach ($enteries as $key => $value):
  ?>

  <tr>
    <td><?php echo $value->id; ?></td>
    <td><?php echo $value->name; ?></td>
    <td><?php echo $value->value; ?></td>
    <td><a href="admin.php?page=all_enteries&edit=<?php echo $value->id; ?>">Edit</a></td>
    <td><a href="admin.php?page=all_enteries&delete=<?php echo $value->id; ?>" onclick="confirmDelete(event);">Delete</a></td>
    
  </tr>
    

  <?php
  endforeach;

  ?>
</table>

<?php endif; ?>