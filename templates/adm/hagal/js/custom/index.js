$(function() {

    //===== Hide/show sidebar =====//
    $('.fullview').click(function() {
        $("body").toggleClass("clean");
        $('#sidebar').toggleClass("hide-sidebar mobile-sidebar");
        $('#content').toggleClass("full-content");
    });

    //===== Hide/show action tabs =====//
    $('.showmenu').click(function() {
        $('.actions-wrapper').slideToggle(100);
    });

    //===== Tooltips =====//
    $('.tip').tooltip();
    $('.focustip').tooltip({'trigger': 'focus'});

    //===== Easy tabs =====//
//    $('.sidebar-tabs').easytabs({
//        animationSpeed: 150,
//        collapsible: false,
//        tabActiveClass: "active"
//    });

//    $('.actions').easytabs({
//        animationSpeed: 300,
//        collapsible: false,
//        tabActiveClass: "current"
//    });

    //===== Collapsible plugin for main nav =====//
//    $('.expand').collapsible({
//        defaultOpen: 'current,third',
//        cookieName: 'navAct',
//        cssOpen: 'subOpened',
//        cssClose: 'subClosed',
//        speed: 200
//    });

    //===== Form elements styling =====//
//    $(".ui-datepicker-month, .styled, .dataTables_length select").uniform({radioClass: 'choice'});

});