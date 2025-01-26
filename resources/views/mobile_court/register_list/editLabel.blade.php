<div class="panel panel-default">
    <div class="panel-heading smx">
        <h2 class="panel-title">রেজিস্টার লেবেল</h2>
    </div>
    <div class="panel-body cpv">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <form method="post" autocomplete="off" action="{{ url("register_list/editLabel/") }}">
                        <input hidden name="label_id" value="{{ label.id }}"/>
                        <input name="register_label" value="{{ label.label }}" class="form-group">
                    <button class="btn-xs btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


