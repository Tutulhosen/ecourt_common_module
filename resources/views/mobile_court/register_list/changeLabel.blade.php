<div class="panel panel-default">
    <div class="panel-heading smx">
        <h2 class="panel-title">রেজিস্টার লেবেল</h2>
    </div>
    <div class="panel-body cpv">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Label</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for labels in labelList %}
                                <tr style="text-align: center">
                                    <td>{{ loop.index }}</td>
                                    <td>{{ labels.label }}</td>
                                    <td>{{ link_to("register_list/editLabel?label_id="~ labels.id , ' পরিবর্তন  ', "class": "btn-xs btn-primary" )}}</td>
                                </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>