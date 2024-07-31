<div class="container">
	<h1>Administration Panel</h1>
	<div class="alert alert-secondary">
		<h3>Users (<?php echo(sizeof($userlist))?>)
    <button id="shrinkUsers" onClick="shrinkUsers()" class="btn btn-outline-primary" style="display: none; float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
</svg></button>
    <button id="expandUsers" onClick="expandUsers()" class="btn btn-outline-primary" style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
</svg></button>
</h3> </div>
	<table style="display: none" id="userList" class="table">
		<tr>
			<th>Username</th>
			<th>Transactions</th>
			<th>Complaints Filed</th>
			<th>Suspensions</th>
			<th>Details</th>
		</tr>
		<?php foreach($userlist as $user) { ?>
			<tr>
				<td>
					<?= $user['username'] ?>
				</td>
				<td>
					<?= $user['email'] ?>
				</td>
				<td>
					<?= $user['complaint_count'] ?>
				</td>
				<td>
					<?= $user['suspension_count'] ?>
				</td>
				<td><a href="<?php echo site_url("Admin/User/".$user['user_id'])?>">Details</td>
    		</tr>
		<?php }?>
</table>
<div class="alert alert-secondary">
    <h3>Transactions (<?php echo(sizeof($transactions))?>)
    <button id="shrinkTransactions" onClick="shrinkTransactions()" class="btn btn-outline-primary" style="display: none; float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
</svg></button>
    <button id="expandTransactions" onClick="expandTransactions()" class="btn btn-outline-primary" style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
</svg></button>
</h3>
</div>
<table style="display: none" id="transactionList" class="table">
    <tr>
        <th>Buyer Username</th>
        <th>Seller Username</th>
        <th>Product</th>
        <th>Detail</th>
    </tr>
    <?php foreach($transactions as $transaction) { ?>
    <tr>
      <td><?= $transaction['buyer'] ?></td>
      <td><?= $transaction['seller'] ?></td>
      <td><?= $transaction['product'] ?></td>
      <td><a href="<?php echo site_url("Admin/Transaction/".$transaction['transaction_id'])?>">Details</a></td>
			</tr>
			<?php }?>
	</table>
</div>
<script>
function expandUsers() {
	var table = document.getElementById("userList");
	var expand = document.getElementById("expandUsers");
	var shrink = document.getElementById("shrinkUsers");
	if(table.style.display === "none") {
		table.style.display = "table";
		expand.style.display = "none";
		shrink.style.display = "block";
	} else {}
}

function shrinkUsers() {
	var table = document.getElementById("userList");
	var expand = document.getElementById("expandUsers");
	var shrink = document.getElementById("shrinkUsers");
	if(table.style.display === "table") {
		table.style.display = "none";
		expand.style.display = "block";
		shrink.style.display = "none";
	} else {}
}

function expandTransactions() {
	var table = document.getElementById("transactionList");
	var expand = document.getElementById("expandTransactions");
	var shrink = document.getElementById("shrinkTransactions");
	if(table.style.display === "none") {
		table.style.display = "table";
		expand.style.display = "none";
		shrink.style.display = "block";
	} else {}
}

function shrinkTransactions() {
	var table = document.getElementById("transactionList");
	var expand = document.getElementById("expandTransactions");
	var shrink = document.getElementById("shrinkTransactions");
	if(table.style.display === "table") {
		table.style.display = "none";
		expand.style.display = "block";
		shrink.style.display = "none";
	} else {}
}
</script>