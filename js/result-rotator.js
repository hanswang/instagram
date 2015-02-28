(function(u, m, k, t) {
    var users = u;
    var medias = m;
    var keyword = k;
    var token = t;

    var userTemplate = '<div class="span"> \
                            <img src="<%- u.profile_picture %>"> \
                            <p><span class="label label-info">Username:</span><span> <%- u.username %></span></p> \
                            <p><span class="label label-info">Full name:</span><span> <%- u.full_name %></span></p> \
                            <p><span class="label label-info">Bio:</span><span> <%- u.bio %></span></p> \
                            <% if (u.website.length > 0) {%> \
                            <p><span class="label label-info">Website:</span><span> <%- u.website %></span></p> \
                            <% } %> \
                        </div>';
    var mediaTemplate = '<div class="span"> \
                            <img src="<%- m.images.standard_resolution.url %>"> \
                            <p> \
                                <span class="label label-info">by user:</span> \
                                <ul> \
                                    <li><span class="label label-info">Username:</span> <span> <%- m.user.username %></span></li> \
                                    <li><span class="label label-info">A.K.A</span> <span> <%- m.user.full_name %></li> \
                                    <li><span class="label label-info">Looks like:</span> <img src="<%- m.user.profile_picture %>"></li> \
                                    <li><span class="label label-info">text:</span> <span> <%- m.caption.text %></span></li> \
                                </ul> \
                            </p> \
                            <p><span class="label label-info">Likes:</span><span> <%- m.likes.count %></span></p> \
                        </div>';

    // define display seconds
    var pausing_time = 8000;

    var collect_time = 10000;

    var showItem = function(item) {
        if (item.type !== undefined) {
            // media display
            $('#item').html(_.template(mediaTemplate)({'m':item}));
        } else {
            // user display
            $('#item').html(_.template(userTemplate)({'u':item}));
        }
    }

    var iter = 1;

    showItem(users[0]);

    function displayItemLoop() {
        var u_length = users.length;
        var m_length = medias.length;

        if (u_length + m_length === 0) {
            return;
        }

        if (iter >= u_length + m_length) {
            iter = iter % (u_length + m_length);
        }

        if (iter < u_length) {
            showItem(users[iter]);
        } else {
            showItem(medias[iter - u_length]);
        }
        iter += 1;
    }

    function ajaxFectchData() {
        var min_id = false;
        if (medias.length > 0) {
            min_id = medias[0].id;
        }
        var param = {
            q: keyword,
            token: token,
            m: min_id
        };

        $.ajax({
            url: '/ajaxLoad.php',
            type: 'POST',
            dataType: 'json',
            data: param,
            success: function(resp) {
                if (resp.status === undefined) {
                    var newMedia = resp.media;
                    var newUser = resp.user;

                    var userIds = users.map(function(u) {return u.id;});
                    var mediaIds = medias.map(function(m) {return m.id;});

                    for (var i = newUser.length - 1; i >= 0; i--) {
                        if (userIds.indexOf(newUser[i].id) < 0) {
                            users.push(newUser[i]);
                        }
                    };

                    for (var i = newMedia.length - 1; i >= 0; i--) {
                        if (mediaIds.indexOf(newMedia[i].id) < 0) {
                            medias.push(newMedia[i]);
                        }
                    };
                }
            }
        });
    }

    $(document).ready(function() {

        setInterval(displayItemLoop, pausing_time);

        setInterval(ajaxFectchData, pausing_time);

    });

})(users, medias, keyword, token)