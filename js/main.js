//Event handlers

$(document).ready(function() {
	$("#submit").click(insertTask);
	$(document).on("click","button[id|=delete]",function() {
		deleteTask($(this).attr('id'));
	});
	$("ul#my-list li").live("click",showUpdateForm);
});

//Insert process

function insertTask() {
	
	$("#the-form").submit(function(event) {
		event.preventDefault();
	});
	
	if ($("#task").val()) {
		var post = $("#the-form").serialize();
		$.post("insert.php", post, function(data) {
			checkServer();
		});
	}
}

function checkServer(data) {
	$.post("read.php", $("#the-form").serialize(), function(data2) {
		updateList(data2);
	});
}

function updateList(data) {
	$("#task").val('');
	$("#my-list").prepend(data);
}

// Delete process
function deleteTask(id) {
	id = id.substring(7);
	idPost = 'id=' + id;
	$.post("delete.php",idPost, function(data) {
		$("#"+ id).parent().remove();	
	});
}


//Update process

function showUpdateForm() {
	var task = $(this).html();
	var idTask = $(this).attr("id");

	$(this).hide();
	$("[id=delete-" + idTask + "]").hide();
	var updateInput = '<input type="text" name="update" id="input-' + idTask + '" required value="' + task + '" />';
	var updateButton = '<button type="submit" id="update-' + idTask + '" class="btn btn-small btn-success">Update</button>';
	var cancelButton = '<button id="cancel-' + idTask + '" class="btn btn-link">Cancel</button>';
	var updateForm = '<form id="updateForm-' + idTask + '" method="POST" action="update.php">' + updateInput + updateButton + cancelButton + '</form>';

	$(this).parent().append(updateForm);
	$("[id=input-" + idTask + "]").focus().select();

	$("[id=cancel-" + idTask + "]").click(function(event) {
		event.preventDefault();
		$("[id=updateForm-" + idTask + "]").remove();
		$("[id=" + idTask + "]").show();
		$("[id=delete-" + idTask + "]").show();
	})

	$("[id=update-" + idTask + "]").click(function(event) {
		event.preventDefault();
		updateTask(idTask);
	});
}

function updateTask(idTask) {
	var post = $("[id=updateForm-" + idTask + "]").serialize() + '&id='+ idTask;
	$.post("update.php",post,function(data) {
		$("[id=updateForm-" + idTask + "]").remove();
		$("[id=" + idTask + "]").html(data);
		$("[id=" + idTask + "]").show();
		$("[id=delete-" + idTask + "]").show();
	});
}
