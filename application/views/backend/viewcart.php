<div class="row">
<div class="col s12">
<div class="row">
<div class="col s12 drawchintantable">
<?php $this->chintantable->createsearch(" List of cart");?>
<table class="highlight responsive-table">
<thead>
<tr>
<th data-field="id">ID</th>
<!--<th data-field="user">User</th>-->
<th data-field="quantity">Quantity</th>
<th data-field="product">Product</th>
<th data-field="size">Size</th>
<th data-field="color">Color</th>
<th data-field="timestamp">Timestamp</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
</div>
</div>
<?php $this->chintantable->createpagination();?>
<!--<div class="createbuttonplacement"><a class="btn-floating btn-large waves-effect waves-light blue darken-4 tooltipped" href="<?php echo site_url("site/createcart"); ?>"data-position="top" data-delay="50" data-tooltip="Create"><i class="material-icons">add</i></a></div>-->
</div>
</div>
<script>
function drawtable(resultrow) {
return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.quantity + "</td><td>" + resultrow.product + "</td><td>" + resultrow.size + "</td><td>" + resultrow.color + "</td><td>" + resultrow.timestamp + "</td><td></td></tr>";
}
generatejquery("<?php echo $base_url;?>");
</script>
