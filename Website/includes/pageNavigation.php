<div class="pageNumber">
    <form id="PageInfo" action="#" method="get">
        <input type="number" name="rubriekID" value="<?php echo ($rubiekID); ?>" hidden>
        <input type="button" onclick="CountPage(-1)" value="<">
        <input type="number" onChange="this.form.submit()" name="page" id="pageNumber" value = "<?php echo ($page) ?>">
        <input type="button" onclick="CountPage(1)" value=">">
    </form>
</div>