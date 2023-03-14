(function ($) {
    $(document).ready(function () {
        var App = {
            alertMsg: function ($title, $text, $icon) {
                Swal.fire({
                    title: $title,
                    text: $text,
                    icon: $icon,
                })
            },
            loader: function () {
                Swal.showLoading();
            },
            clear_cache: function (data) {
                var Obj = this;
                $.ajax({
                    type: 'POST',
                    url: rcn_admin_config.ajaxurl,
                    data: data,
                }).done(function (data) {
                    let response = JSON.parse(data);
                    console.log(response);
                    if (response == 'success') {
                        Obj.alertMsg(rcn_admin_config.data_refresh.title, rcn_admin_config.data_refresh.msg, 'success');
                    } else if (response == 'error') {
                        Obj.alertMsg('Sorry!', response, 'error');
                    } else if (response == 'must_admin') {
                        Obj.alertMsg('Sorry!', rcn_admin_config.data_refresh.must_admin, 'error');
                    } else {
                        Obj.alertMsg('Sorry!', response, 'error');
                    }
                }).fail(function () {
                    alert("The Ajax call itself failed.");
                });
            }
        }

        $(document).on('click', '#rcn-refresh-data', function (e) {
            e.preventDefault();
            let data = {
                'action': 'rcn_feed_refresh',
                'refresh': true,
            };
            App.loader();
            App.clear_cache(data);
        });
    });
}(jQuery));