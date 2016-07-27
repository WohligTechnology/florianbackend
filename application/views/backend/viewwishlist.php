<div class="row">
<div class="col s12">
<div class="row">
<div class="col s12 drawchintantable">
<?php $this->chintantable->createsearch(" List of wishlist");?>
<table class="highlight responsive-table">
<thead>
<tr>
<th data-field="id">ID</th>
<!--<th data-field="user">User</th>-->
<th data-field="productname">Product Name</th>
<th data-field="timestamp">Timestamp</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
</div>
</div>
<?php $this->chintantable->createpagination();?>
</div>
</div>
<script>
function drawtable(resultrow) {
return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.productname + "</td><td>" + resultrow.timestamp + "</td><td></td></tr>";
}
generatejquery("<?php echo $base_url;?>");
</script>
