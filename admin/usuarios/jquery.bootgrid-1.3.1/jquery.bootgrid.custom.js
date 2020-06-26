/*! 
 * jQuery Bootgrid v1.3.1 - 09/11/2015
 * Copyright (c) 2014-2015 Rafael Staib (http://www.jquery-bootgrid.com)
 * Licensed under MIT http://www.opensource.org/licenses/MIT
 */
;
(function ($, window, undefined) {
    /*jshint validthis: true */
    "use strict";
    
    $.extend($.fn.bootgrid.Constructor.defaults, {
        navigation: 3, // it's a flag: 0 = none, 1 = top, 2 = bottom, 3 = both (top and bottom)
        padding: 2, // preenchimento de página (paginação)
        columnSelection: true,
        rowCount: [10, 25, 50, 100, -1], // linhas por página int ou array de int (-1 representa "All")        
    });
    
    $.extend($.fn.bootgrid.Constructor.defaults.css, {
        icon: "fa",
        iconColumns: "fa-th-list",
        iconRefresh: "fa-refresh",
        iconSearch: "fa-search",
        iconUp: "fa-sort-amount-asc",
        iconDown: "fa-sort-amount-desc",
        pagination: "pagination pagination-sm justify-content-center",
        paginationButton: "page-link",
        infos: "infos text-center",

        search: "search input-group",
    });

    $.extend($.fn.bootgrid.Constructor.defaults.labels, {
        all: "Todos",
        infos: "Resultado {{ctx.start}} ao {{ctx.end}} de {{ctx.total}} registros",
        //loading: "Carregando...",
        loading: "<i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i>",
        noResults: "Nenhum resultado encontrado!",
        refresh: "Atualizar",
        search: "Pesquisa"
    });

    $.extend($.fn.bootgrid.Constructor.defaults.templates, {

        header:
                "<div id='{{ctx.id}}' class='{{css.header}}'>" +
                "<div class='row align-items-center'>" +
                "<div class='col-auto'>" +
                '<button type="button" class="btn btn-default" id="command-add" data-row-id="0">' +
                '<i class="fa fa-plus"></i>' +
                '</button>' +
                "</div>" +
                "<div class='col-auto'>" +
                "<p class='{{css.actions}}'></p>" +
                "</div>" +
                "<div class='col-auto ml-auto'>" +
                "<p class='{{css.search}}'></p>" +
                "</div>" +
                "</div>" +
                "</div>",

        search:
                "<div class='{{css.search}}'>" +
                "<div class='input-group-prepend'>" +
                "<div class='input-group-text'><span class='{{css.icon}} {{css.iconSearch}}'></span></div>" +
                "</div>" +
                "<input type='text' class='{{css.searchField}}' placeholder='{{lbl.search}}' />" +
                "</div>",

        footer: "<div id='{{ctx.id}}' class='{{css.footer}}'><div class='row'><div class='col-sm-12 infoBar'><p class='{{css.infos}}'></p></div><div class='col-sm-12'><p class='{{css.pagination}}'></p></div></div></div>",
        paginationItem: '<li class="page-item"><a class="page-link" data-page="{{ctx.page}}">{{ctx.text}}</a></li>',
    });

})(jQuery, window);