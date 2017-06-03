<h1>
    Task List
    
    <a href="<?=base_url()."task/form"?>" style="float: right">Create Task</a>
</h1>
<table class="table-bordered" style="width: 100%">
    <thead>
        <tr class="">
            <th>#</th>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    if($result): 
        $si = 1;
    ?>
        <?php foreach($result->result() as $r): ?>
        <tr>
            <td><?=$si++?></td>
            <td><?=$r->name?></td>
            <td><?=$r->description?></td>
            <td>
                <a href="<?=base_url()."task/delete/".$r->task_id?>" onclick="return app.confirmDelete(<?=(int)$r->task_id?>);">Delete</a>
                &nbsp;
                <a href="<?=base_url()."task/form/".$r->task_id?>">Edit</a>
            </td>            
        </tr>
        <?php endforeach; ?>
    <?php 
    endif; 
    ?>    
    </tbody>
</table>

<script>
    var app = app || {};
    app.confirmDelete = function($task_id){
        if(!confirm("Do you really want to delete?")){
            return false;
        }

        $.ajax({
            url : app.baseUrl + "task/delete/"+$task_id,
            type : "post",
            dataType : 'json',
            success : function(data){                        
                if(data.success){
                    alert("Task has been deleted");
                    window.location = app.baseUrl + "task";
                    return false;
                }

                alert(data.msg);
            },
            error : function(data){                
                alert("There was a problem. Please try again later :: "+data.msg);
                console.log(data.msg);
            }
        });
        return false;
    };
</script>