$(function() {
    "use strict";

    const baseurl = window.location.protocol + "//" + window.location.host + "/",
          loader = '<p class="display-1 m-5 p-5 text-center text-warning">'+
                        '<i class="fas fa-circle-notch fa-spin "></i>'+
                    '</p>',
          att_div = '<div class="att-item">'+
                        '<input type="file" name="attatcement[]" placeholder="ফাইল সিলেক্ট করুন"> '+
                        '<input type="text" name="name[]" placeholder="ফাইলের নাম লিখুন"> '+ 
                        '<button type="button" class="btn btn-danger btn-sm remove-attatchment">&#10006;</button> '+
                        '<button type="button" class="btn btn-success btn-sm add-attatchment">&#10010;</button> '+ 
                    '</div>',
          baseTitle = ' | স্মৃতির পাতা';

    
    $('.pagecontent').summernote({
        height:450,
    });

    

    $('.share-to-user').select2();
    /*
    {
        ajax: {
            url: baseurl+'search/user/',
            dataType: 'json',
            data: function (params) {
              var query = {
                search: params.term
              }
              return query;
            },
            processResults: function (data) {
              return {
                results: data
              };
            }
        }
    
    }
    */
    $(document).on('click','.add-attatchment', function(){
        $('.att-area').append(att_div);
    });

    $(document).on('click','.remove-attatchment', function(){
        $(this).parent().remove();
    });
    // close topic
    $(document).on('click','.btn-close', function(){
    	$(this).parent().parent().parent().hide();
    });

    // add topic 
    $(document).on('click','.topic-add', function() {
    	const el = $('.topic-input');
    	if(el.hasClass('hide')){ 		
	    	el.removeClass('hide'),$('p',this).html('<i class="fas fa-times nav-icon text-danger"></i> বাতিল করুন');
    	}else{
	    	el.addClass('hide'),$('#topic-name').val(''),$('p',this).html('<i class="fas fa-plus nav-icon "></i> নতুন টপিক যোগ করুন');
    	}
    });

    // store topic
    $(document).on('click','.topic-store', function() {
    	const el = $('.topic-store'),
    		  title = $('#topic-name').val();
    	if(title != ''){
            el.attr('disabled', true);
	    	el.html('<i class="fas fa-circle-notch fa-spin"></i>');
	    	$.ajax({
	            type: "POST",
	            url : baseurl+'topic/store', 
	            data: {
	                '_token' : $('[name="_token"]').val(),
	                'title' : title,
	            }, 
	            traditional: true,
	            success: function (res) {
	            	if(res.status == true){
	            		$('.topic-list').append(res.content),$('.topic-input').addClass('hide'),$('#topic-name').val(''),
		    			$('.topic-add p').html('<i class="fas fa-plus nav-icon "></i> নতুন টপিক যোগ করুন');
                        el.html('<i class="fas fa-check"></i>');
                        
	            	}else{
	            		el.html('<i class="fas fa-redo-alt"></i>');
	            	}
                    el.attr('disabled', false);
	            }
	        });
    	}else{
            $('#topic-name').addClass('danger');
        }
    }); 

    // edit topic
    $(document).on('click','.topic-edit', function(){
    	$(this).parent().parent().parent().next().show();
    });

    

    // update topic
    $(document).on('click','.topic-update', function() {
    	const el = $(this),
    		  id = el.data('id'),
    		  title = el.parent().prev().val(),
    		  url = 'topic/update/'+id;

    	//console.log(title);

    	if(title != ''){
            el.attr('disabled', true);
	    	el.replaceWith('<i class="fas fa-circle-notch fa-spin "></i>');
	    	$.ajax({
	            type: "POST",
	            url : baseurl+url, 
	            data: {
	                '_token' : $('[name="_token"]').val(),
	                'title' : title,
	            }, 
	            traditional: true,
	            success: function (res) {
	            	if(res.status == true){
	            		$('.nav-key-'+id).replaceWith(res.content);
                        el.html('<i class="fas fa-check"></i>');
	            	}else{
	            		el.replaceWith('<i class="fas fa-redo-alt topic-update"></i>');
	            	}
                    el.attr('disabled', false);
	            }
	        });
    	}else{
            el.parent().prev().addClass('danger');
        }
    }); 

    // delete 
    $(document).on('click','.topic-delete', function() 
    {
        const el = $(this),
    		  id = el.data('id'),
    		  url = 'topic/delete/'+id;
        var active = false;
        if(el.parent().parent().parent().hasClass('active')){
            active = true;
        }
        swal({
            title: 'মুছে ফেলুন',
            text: 'আপনি কি মুছে ফেলতে চান?',
            icon: 'warning',
            buttons: true,
            buttons: {
                cancel: {
                    text: "না",
                    value: false,
                    visible: true,
                    closeModal: true,
                },
                confirm: {
                    text: "হ্যাঁ",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: false
                }
            },
            dangerMode: false,
            closeOnClickOutside: false
        }).then(function(value) {
            if (value) {
                $.ajax({
                    type: "GET",
                    url : baseurl+url, 
                    traditional: true,
                    success: function (response) {
                        swal.stopLoading();
                        if(response.status == true){
                            el.parent().parent().parent().parent().remove();
                            if(active){
                                location.reload();
                            }
                            swal({
                                title: 'সফল!',
                                text: 'টপিক মুছে ফেলা হয়েছে',
                                icon: 'success',
                                buttons: false,
                                timer:1500
                            });
                        }

                    }
                });  
            }
        });
    });



    // section js starts here

    // add section 
    $(document).on('click','.section-add', function() {
    	const el = $('.section-input');
    	if(el.hasClass('hide')){ 		
	    	el.removeClass('hide'),$('p',this).html('<i class="fas fa-times nav-icon text-danger"></i> বাতিল করুন');
    	}else{
	    	el.addClass('hide'),$('#section-name').val(''),$('p',this).html('<i class="fas fa-plus nav-icon "></i> নতুন সেকশন যোগ করুন');
    	}
    });

    // store section
    $(document).on('click','.section-store', function() {
    	const el = $('.section-store'),
    		  topic_id = $(this).data('topic'),
    		  title = $('#section-name').val();
    	if(title != '' && topic_id != ''){
            el.attr('disabled', true);
	    	el.html('<i class="fas fa-circle-notch fa-spin"></i>');
	    	$.ajax({
	            type: "POST",
	            url : baseurl+'section/store', 
	            data: {
	                '_token' : $('[name="_token"]').val(),
	                'title' : title,
	                'topic_id' : topic_id
	            }, 
	            traditional: true,
	            success: function (res) {
	            	if(res.status == true){
	            		$('.section-nav').append(res.content),$('.section-input').addClass('hide'),$('#section-name').val(''),
		    			$('.section-add p').html('<i class="fas fa-plus nav-icon "></i> নতুন সেকশন যোগ করুন');
                        el.html('<i class="fas fa-check"></i>');
	            	}else{
	            		el.html('<i class="fas fa-redo-alt"></i>');
	            	}
                    el.attr('disabled', false);
	            }
	        });
    	}else if(title == ''){
            $('#section-name').addClass('danger');
        }
    }); 

    // edit section
    $(document).on('click','.section-edit', function(){
    	$(this).parent().parent().parent().next().show();
    });

    

    // update section
    $(document).on('click','.section-update', function() {
    	const el = $(this),
    		  id = el.data('id'),
    		  title = el.parent().prev().val(),
    		  url = 'section/update/'+id;

    	//console.log(title);

    	if(title != ''){
            el.attr('disabled', true);
	    	el.replaceWith('<i class="fas fa-circle-notch fa-spin "></i>');
	    	$.ajax({
	            type: "POST",
	            url : baseurl+url, 
	            data: {
	                '_token' : $('[name="_token"]').val(),
	                'title' : title,
	            }, 
	            traditional: true,
	            success: function (res) {
	            	if(res.status == true){
	            		$('.section-key-'+id).replaceWith(res.content);
                        el.html('<i class="fas fa-check"></i>');
	            	}else{
	            		el.replaceWith('<i class="fas fa-redo-alt section-update"></i>');
	            	}
                    el.attr('disabled', false);
	            }
	        });
    	}else{
            el.parent().prev().addClass('danger');
        }
    }); 

    // delete 
    $(document).on('click','.section-delete', function() 
    {
        const el = $(this),
    		  id = el.data('id'),
    		  url = 'section/delete/'+id;
        var active = false;
        if(el.parent().parent().parent().hasClass('active')){
            active = true;
        }
        swal({
            title: 'মুছে ফেলুন',
            text: 'আপনি কি মুছে ফেলতে চান?',
            icon: 'warning',
            buttons: true,
            buttons: {
                cancel: {
                    text: "না",
                    value: false,
                    visible: true,
                    closeModal: true,
                },
                confirm: {
                    text: "হ্যাঁ",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: false
                }
            },
            dangerMode: false,
            closeOnClickOutside: false
        }).then(function(value) {
            if (value) {
                $.ajax({
                    type: "GET",
                    url : baseurl+url, 
                    traditional: true,
                    success: function (response) {
                        swal.stopLoading();
                        if(response.status == true){
                            el.parent().parent().parent().parent().remove();
                            if($('.section-nav li').length === 0){
                                $('.page-add').addClass('disabledarea').attr('data-section', );
                            }
                            if(active){
                                location.reload();
                            }
                            swal({
                                title: 'সফল!',
                                text: 'সেকশনটি মুছে ফেলা হয়েছে',
                                icon: 'success',
                                buttons: false,
                                timer:2000
                            });
                        }

                    }
                });  
            }
        });
    });

    $(document).on('click', '.page-add', function(){
    	const section_id = $(this).data('section');
    	// loader
    	$('.page-content').html(loader);
    	$.ajax({
            type: "GET",
            url : baseurl+'page/create', 
            data: {section_id:section_id}, 
            traditional: true,
            success: function (res) {
            	if(res.status == true){
            		$('.page-content').html(res.content);
            		$('.page-anchor').removeClass('active')
            		$('.pagecontent').summernote({
				        height:250,
				    });
            	}else{
            	}
            }
        });

    });

    $(document).on('click', '.page-save', function(){
    	const el = $(this);
            
        var title = $('.page-title').val(),
            content = $('.pagecontent').val(),
            form_data = new FormData(document.getElementById("page-form"));
        

        if(title != '' && content != '')
        {
            if(el.find('i').length === 0){
                el.append(' &nbsp;<i class="fas fa-circle-notch fa-spin" style="font-size:12px;"></i>');
            }else{
                el.find('i').replaceWith('<i class="fas fa-circle-notch fa-spin" style="font-size:12px;"></i>');
            }
        	$.ajax({
                type: "POST",
                url : baseurl+'page/store', 
                data: form_data,
                processData: false,
                contentType: false,
                traditional: true,
                success: function (res) {
                	if(res.status == true){
                		$('.page-anchor').parent().parent().removeClass('active')
                		$('.page-nav').append(res.menu_item);
                		$('.page-content').html(res.content);
    				    
                        var url = baseurl+'content?topic='+res.section.topic_id+'&section='+res.page.section_id+'&page='+res.page.id;
                        var title = res.page.title;
                       
                        window.history.pushState('','',url);
                        document.title = title+baseTitle;
                        fancy();
                	}else{

                		el.find('i').replaceWith('<i class="fas fa-redo-alt" style="font-size:12px;"></i>');
                	}
                }
            });
        }

        if(title == ''){
            $('.page-title').addClass('danger');
        }

        if(content == ''){
            $('.pagecontent').addClass('danger');
        }


    });

    $(document).on('click','.page-delete', function() 
    {
        const el = $(this),
              id = el.data('id'),
              url = 'page/delete/'+id;
        var active = false;
        if(el.parent().parent().parent().hasClass('active')){
            active = true;
        }

        swal({
            title: 'মুছে ফেলুন',
            text: 'আপনি কি মুছে ফেলতে চান?',
            icon: 'warning',
            buttons: true,
            buttons: {
                cancel: {
                    text: "না",
                    value: false,
                    visible: true,
                    closeModal: true,
                },
                confirm: {
                    text: "হ্যাঁ",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: false
                }
            },
            dangerMode: false,
            closeOnClickOutside: false
        }).then(function(confirmed) {
            if (confirmed) {
                $.ajax({
                    type: "GET",
                    url : baseurl+url, 
                    traditional: true,
                    success: function (response) {
                        swal.stopLoading();
                        if(response.status == true){
                            el.parent().parent().parent().parent().remove();
                            if(active){
                                location.reload();

                            }
                            swal({
                                title: 'সফল!',
                                text: 'পৃষ্ঠাটি মুছে ফেলা হয়েছে',
                                icon: 'success',
                                buttons:false,
                                timer:2000
                            });
                        }

                    }
                });  
            }
        });
    });

    $(document).on('click','.page-edit', function(){
        const id = $(this).data('id'),
              el = $(this);
        // loader
        $('.page-content').html(loader);
        $.ajax({
            type: "GET",
            url : baseurl+'page/edit/'+id, 
            traditional: true,
            success: function (res) {
                if(res.status == true){
                    $('.page-content').html(res.content);
                    fancy();
                    $('.pagecontent').summernote({
                        height:250,
                    });
                    
                }else{
                }
            }
        });
    });

    $(document).on('click', '.page-update', function(){
        const el = $(this), id = $(this).data('id');
            
        var title = $('.page-title').val(),
            content = $('.pagecontent').val(),
            form_data = new FormData(document.getElementById("page-form"));
        if(title != '' && content != '')
        {
            if(el.find('i').length === 0){
                el.append(' &nbsp;<i class="fas fa-circle-notch fa-spin" style="font-size:12px;"></i>');
            }else{
                el.find('i').replaceWith('<i class="fas fa-circle-notch fa-spin" style="font-size:12px;"></i>');
            }
            $.ajax({
                type: "POST",
                url : baseurl+'page/update/'+id, 
                data: form_data,
                processData: false,
                contentType: false,
                traditional: true,
                success: function (res) {
                    if(res.status == true){
                        $('.page-content').html(res.content);
                        fancy();
                    }else{

                        el.find('i').replaceWith('<i class="fas fa-redo-alt" style="font-size:12px;"></i>');
                    }
                }
            });
        }

        if(title == ''){
            $('.page-title').addClass('danger');
        }

        if(content == ''){
            $('.pagecontent').addClass('danger');
        }

    });

    // load dynamic content: page
    $(document).on('click','.page-anchor', function(){
    	const id = $(this).data('id'),
    		  el = $(this);
    	// loader
    	$('.page-content').html(loader);
    	$.ajax({
            type: "GET",
            url : baseurl+'page/show/'+id, 
            traditional: true,
            success: function (res) {
            	if(res.status == true){
            		$('.page-content').html(res.content),$('.page-anchor').parent().parent().removeClass('active'),
            		el.parent().parent().addClass('active');
                    var url = baseurl+'content?topic='+res.section.topic_id+'&section='+res.page.section_id+'&page='+res.page.id;
                    var title = res.page.title;
                   fancy();
                    window.history.pushState('','',url);
                    document.title = title+baseTitle;

            		
            	}else{
            	}
            }
        });
    });

    $(document).on('click','.section-anchor', function(){
        const id = $(this).data('id'),
              el = $(this);
        // loader
        $('.page-content').html(loader);
        $.ajax({
            type: "GET",
            url : baseurl+'section/show/'+id, 
            traditional: true,
            success: function (res) {
                if(res.status == true){
                    $('.page-menu').replaceWith(res.menu),$('.page-content').html(res.content),
                    $('.section-anchor').parent().parent().removeClass('active'), 
                    el.parent().parent().addClass('active');
                    new SimpleBar($('#page-menu')[0]);

                    var url = baseurl+'content?topic='+res.section.topic_id+'&section='+res.section.id;
                    var title = res.section.title;
                    if(res.section.page[0]){
                        url = url+'&page='+res.section.page[0].id;
                        var title = res.section.page[0].title;
                    }
                    fancy();
                    window.history.pushState('','',url);
                    document.title = title+baseTitle;
                    
                }
            }
        });
    });

    $('#modal-share').on('show.bs.modal', function() {
        var id = $('.page-share').data('id'),
            title = $('.page-share').data('title');
        $('.share-public').attr('data-id',id);
        $('.share-private').attr('data-id',id);
        $('.share-title').html(title);
    });

    // share
    $(document).on('click','.share-public', function(){
        const id = $(this).data('id'),
              el = $(this);

        el.append('<i class="fas fa-circle-notch fa-spin "></i>');
        $.ajax({
            type: "GET",
            url : baseurl+'share/public/'+id, 
            traditional: true,
            success: function (res) {
                if(res.status == true){
                    $('.page-share').replaceWith('<span class="page-share-edit text-small" data-toggle="modal" data-target="#modal-share-edit" data-id="'+id+'" data-title="'
                        +$('.memory-page-title').text()+'" data-shared="all"><i class="fas fa-share"></i> সবার সাথে শেয়ার করা হয়েছে </span>');
                    el.find('i').remove();
                    $('#modal-share').modal('hide');
                }
            }
        });
    });


    $(document).on('click','.share-private', function(){
        const id = $(this).data('id'),
              el = $(this);
        var users = JSON.stringify($('.share-to-user').select2('val'));
        if($('.share-to-user').select2('val').length > 0){
            console.log(users.length);
            el.append('<i class="fas fa-circle-notch fa-spin "></i>');
            $.ajax({
                type: "POST",
                url : baseurl+'share/private/'+id, 
                data: {
                    _token : $('[name="_token"]').val(),
                    shared_with : users, 
                },
                traditional: true,
                success: function (res) {
                    if(res.status == true){
                        $('.page-share').replaceWith('<span class="page-share-edit text-small" data-toggle="modal" data-target="#modal-share-edit" data-id="'+id+'" data-title="'
                            +$('.memory-page-title').text()+'" data-shared="user"><i class="fas fa-share"></i> '
                            +res.count+' জনের সাথে শেয়ার করা হয়েছে </span>');
                        el.find('i').remove();
                        $('#modal-share').modal('hide');
                    }
                }
            });
        }
    });

    $('#modal-share-edit').on('show.bs.modal', function() {
        const id = $('.page-share-edit').data('id'),
              el = $(this);

        el.find('.modal-content').html(loader);
        $.ajax({
            type: "GET",
            url : baseurl+'share/edit/'+id,
            data: {
                shared_with : $('.page-share-edit').data('shared')
            }, 
            traditional: true,
            success: function (res) {
                if(res.status == true){
                    el.find('.modal-content').html(res.content);
                    $('.share-to-user').select2();
                }
            }
        });
    });

    // share
    $(document).on('click','.share-public-remove', function(){
        const id = $(this).data('id'),
              el = $(this);

        el.append('<i class="fas fa-circle-notch fa-spin "></i>');
        $.ajax({
            type: "GET",
            url : baseurl+'share/public-remove/'+id, 
            traditional: true,
            success: function (res) {
                if(res.status == true){
                    $('.page-share-edit').replaceWith('<span class="page-share text-small" data-toggle="modal" data-target="#modal-share" data-id="'+id+'" data-title="'+$('.memory-page-title').text()+'"><i class="fas fa-share"></i> শেয়ার করুন</span>')
                    el.find('i').remove();
                    $('#modal-share-edit').modal('hide');
                }
            }
        });
    });

    $(document).on('click','.share-private-remove', function(){
        const id = $(this).data('id'),
              el = $(this);

        el.append('<i class="fas fa-circle-notch fa-spin "></i>');
        $.ajax({
            type: "GET",
            url : baseurl+'share/private-remove/'+id, 
            traditional: true,
            success: function (res) {
                if(res.status == true){
                    $('.page-share-edit').replaceWith('<span class="page-share text-small" data-toggle="modal" data-target="#modal-share" data-id="'+id+'" data-title="'+$('.memory-page-title').text()+'"><i class="fas fa-share"></i> শেয়ার করুন</span>');
                    el.find('i').remove();
                    $('#modal-share-edit').modal('hide');
                }
            }
        });
    });

    $(document).on('click','.share-update', function(){
        const id = $(this).data('id'),
              el = $(this);
        var users = JSON.stringify($('.share-to-user').select2('val'));
        if($('.share-to-user').select2('val').length > 0){
            el.append('<i class="fas fa-circle-notch fa-spin "></i>');
            $.ajax({
                type: "POST",
                url : baseurl+'share/private-update/'+id, 
                data: {
                    _token : $('[name="_token"]').val(),
                    shared_with : users
                },
                traditional: true,
                success: function (res) {
                    if(res.status == true){
                        $('.page-share-edit').replaceWith('<span class="page-share-edit text-small" data-toggle="modal" data-target="#modal-share-edit" data-id="'+id+'" data-title="'
                            +$('.memory-page-title').text()+'" data-shared="user"><i class="fas fa-share"></i> '
                            +res.count+' জনের সাথে শেয়ার করা হয়েছে </span>');
                        el.find('i').remove();
                        $('#modal-share-edit').modal('hide');
                    }
                }
            });
        }
    });


    $(document).on('click','.hide-section', function(){
        if($(this).hasClass('has-fold')){
            $(this).removeClass('has-fold').html('<i class="fas fa-chevron-left"></i> সেকশনসমুহ');
            $('.section-menu').css({'width':'200px'});
            $('.section-menu li.nav-item').show();
            $('.section-add').show();
        }else{
            $(this).addClass('has-fold').html('<i class="fas fa-chevron-right"></i>');;
            $('.section-menu').css({'width':'20px'});
            $('.section-menu li.nav-item').hide();
            $('.section-add').hide();
        }

    });

    $(document).on('click','.hide-page', function(){
        if($(this).hasClass('has-fold')){
            $(this).removeClass('has-fold').html('<i class="fas fa-chevron-left"></i> পৃষ্ঠাসমুহ');
            $('.page-menu').css({'width':'200px'});
            $('.page-menu li.nav-item').show();
            $('.page-add').show();
        }else{
            $(this).addClass('has-fold').html('<i class="fas fa-chevron-right"></i>');;
            $('.page-menu').css({'width':'20px'});
            $('.page-menu li.nav-item').hide();
            $('.page-add').hide();
        }

    });


    $(document).on('click','.att-delete', function() 
    {
        const el = $(this),
              id = el.data('id'),
              url = 'attatchment/delete/'+id;
        swal({
            title: 'মুছে ফেলুন',
            text: 'আপনি কি মুছে ফেলতে চান?',
            icon: 'warning',
            buttons: true,
            buttons: {
                cancel: {
                    text: "না",
                    value: false,
                    visible: true,
                    closeModal: true,
                },
                confirm: {
                    text: "হ্যাঁ",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: false
                }
            },
            dangerMode: false,
            closeOnClickOutside: false
        }).then(function(confirmed) {
            if (confirmed) {
                $.ajax({
                    type: "GET",
                    url : baseurl+url, 
                    traditional: true,
                    success: function (response) {
                        swal.stopLoading();
                        if(response.status == true){
                            el.parent().remove();
                            
                            swal({
                                title: 'সফল!',
                                text: 'পৃষ্ঠাটি মুছে ফেলা হয়েছে',
                                icon: 'success',
                                buttons:false,
                                timer:2000
                            });
                        }

                    }
                });  
            }
        });
    });

    function fancy(){
        $(".fancy").fancybox({
            buttons: [
                'slideShow',
                'fullScreen',
                'thumbs',
                'download',
                'zoom',
                'close'
            ]
        });
    }

    




});

$(function() {
    "use strict";
    $(".fancy").fancybox({
        buttons: [
            'slideShow',
            'fullScreen',
            'thumbs',
            'download',
            'zoom',
            'close'
        ]
    });

    
});