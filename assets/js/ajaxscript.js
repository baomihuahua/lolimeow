$('#image').change(function() {
    for (var i = 0; i < this.files.length; i++) {
        var f = this.files[i];
        if (!/image\/\w+/.test(f.type)) {
            alert('请选择图片文件(png | jpg | gif)');
            return
        }
        var formData = new FormData();
        formData.append('smfile', f);		
		$('#uploadinfo').html('<p class=\"card-text \">上传中...请稍等<img src=\"https://i.loli.net/2018/09/14/5b9bd17b2b43c.gif\" ></p>').fadeIn();	
        $.ajax({
            url: 'https://sm.ms/api/upload',
            type: 'POST',
            processData: false,
            contentType: false,
            data: formData,			beforeSend: function(xhr) {},
            success: function(res) {				
			    $('#uploadinfo').remove();				
				$("#showurl").css("display");				
			    $('#img1').remove();
                $('#img2').append('<img class = "card-img-bottom" src="' + res.data.url + '" alt="MeowData专用图床" style="max-width: 300px;"/>');
                $('#urls').append('<label class="control-label badge badge-pill badge-success">上传成功，请复制图片外链地址</label><div class="form-group">	<input type="text"  value="' + res.data.url + '" class="form-control  is-valid" /> </div>');
                $('#path').append('<div class="form-group"><input type="text"  value="https://i.meowdata.com' + res.data.path + '" class="form-control  is-valid" /> </div>');
				$('#msg').append('<span class = "badge badge-pill badge-success">' + res.data.msg + '</span>');
				$('#delete').append('<a href="' + res.data.delete + '" class="btn-sm btn btn-1 btn-danger mb20" target="_black">删除图床上该图片<div class="ripple-container"></div></a>');
			}
        }) 
    }
});