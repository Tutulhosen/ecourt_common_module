
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <span id="message"> qeqeqeqeqe</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">বন্ধ করুন</button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-header {
        background:#8Dc641;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
</style>

<script>
    function message_show(msg){
        document.getElementById("message").innerHTML = msg;
        $('#myModal').modal('show')
    }
</script>
