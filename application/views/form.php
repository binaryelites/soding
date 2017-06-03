<h1>
    Task Form
    <a href="<?=base_url()."task/"?>" style="float:right">Back To Task List</a>
</h1>

<form class="form" id="taskForm" action="<?=base_url()."task/save/".$taskInfo->task_id?>" method="post">
    <p>
        <label>Name</label>
        <input type="text" name="name" id="task" value="<?=$taskInfo->name?>" required />
    </p>
    <p>
        <label>Description</label>
        <textarea name="description" rows="5" cols="40" id="description" required ><?=$taskInfo->description?></textarea>
    </p>
    <p>
        <button type="submit" id="submit">Save Task</button>
    </p>
</form>
<script>
    var app = app || {};
    app.task_id = <?=(int)$taskInfo->task_id?>;
    $(document).ready(function(e){
        $("#taskForm").validate({
            submitHandler : function($form){
                if(!confirm("Do you really want to save?")){
                    return false;
                }
                
                $("#submit").attr("disabled", "disabled");
                $.ajax({
                    url : app.baseUrl + "task/save/"+app.task_id,
                    type : "post",
                    data : $("#taskForm").serialize(),
                    dataType : 'json',
                    success : function(data){                        
                        $("#submit").removeAttr("disabled");
                        if(data.success){
                            alert("Task has been saved");
                            window.location = app.baseUrl + "task";
                            return false;
                        }
                        
                        alert(data.msg);
                    },
                    error : function(data){
                        $("#submit").removeAttr("disabled");
                        alert("There was a problem. Please try again later :: "+data.msg);
                        console.log(data.msg);
                    }
                });
            }
        });
    });
</script>