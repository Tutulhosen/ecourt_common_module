
<form method="post" autocomplete="off">

<ul class="pager">
    <li class="আগে pull-left">
        {{ link_to("monthly_report", "&larr; প্রথম পাতা") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Save", "class": "btn btn-success") }}
    </li>
</ul>

    <?php echo $this->getContent() ?>

<div class="center scaffold">
    <h2>Create  report</h2>

</div>

</form>