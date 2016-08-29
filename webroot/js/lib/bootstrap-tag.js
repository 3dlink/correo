/* ==========================================================
 * bootstrap-tag.js v2.3.0
 * https://github.com/fdeschenes/bootstrap-tag
 * ==========================================================
 * Copyright 2012 Francois Deschenes.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */

!function ( $ ) {

  'use strict' // jshint ;_;

  var Tag = function ( element, options ) {
    this.element = $(element)
    this.options = $.extend(true, {}, $.fn.tag.defaults, options)
    this.realvalues = $.grep($.map(this.element.val().split(','), function(item){
      var str = item.split('--'); 
      return $.trim(str[1]);
    }), function ( value ) { return value.length > 0 })
    this.values = $.grep($.map(this.element.val().split(','), $.trim), function ( value ) { return value.length > 0 })
    this.show()
  }

  Tag.prototype = {
    constructor: Tag

  , show: function () {
      var that = this

      that.element.parent().prepend(that.element.detach().hide())
      that.element
        .wrap($('<div class="tags" style="width:100%;">'))
        .parent()
        .on('click', function () {
          that.input.focus()
        })

      if (that.values.length) {
        $.each(that.values, function () {
          that.createBadge(this)
        })
      }

      that.input = $('<input type="text" style="display:inline-block; width:150px;">')
        .attr('placeholder', that.options.placeholder)
        .insertAfter(that.element)
        .on('focus', function () {
          that.element.parent().addClass('tags-hover')
        })
        .on('blur', function () {
          if (!that.skip) {
            that.process()
            that.element.parent().removeClass('tags-hover')
            that.element.siblings('.tag').removeClass('tag-important')
          }
          that.skip = false
        })
        .on('keydown', function ( event ) {
          if ( event.keyCode == 188 || event.keyCode == 13 || event.keyCode == 9 ) {
            if ( $.trim($(this).val()) && ( !that.element.siblings('.typeahead').length || that.element.siblings('.typeahead').is(':hidden') ) ) {
              if ( event.keyCode != 9 ) event.preventDefault()
              that.process()
            } else if ( event.keyCode == 188 ) {
              if ( !that.options.autocompleteOnComma ) {
                event.preventDefault()
                that.process()
              }
              else if ( !that.element.siblings('.typeahead').length || that.element.siblings('.typeahead').is(':hidden') ) {
                event.preventDefault()
              } else {
                that.input.data('typeahead').select()
                event.stopPropagation()
                event.preventDefault()
              }
            }
          } else if ( !$.trim($(this).val()) && event.keyCode == 8 ) {
            var count = that.element.siblings('.tag').length
            if (count) {
              var tag = that.element.siblings('.tag:eq(' + (count - 1) + ')')
              if (tag.hasClass('tag-important')) that.remove(count - 1)
              else tag.addClass('tag-important')
            }
          } else {
            that.element.siblings('.tag').removeClass('tag-important')
          }
        })
        .typeahead({
          source: that.options.source
        , matcher: function ( value ) {
            return ~value.toLowerCase().indexOf(this.query.toLowerCase()) && (that.inValues(value) == -1 || that.options.allowDuplicates)
          }
        , updater: $.proxy(that.add, that)
        })

      $(that.input.data('typeahead').$menu).on('mousedown', function() {
        that.skip = true
      })

      this.element.trigger('shown')
    }
  , inValues: function ( value ) {
      var display = value;
      if (value.match('--')){
        var str = value.split('--');
        display = str[1];
        
      }
      if (this.options.caseInsensitive) {
        var index = -1
        $.each(this.realvalues, function (indexInArray, valueOfElement) {
          if ( valueOfElement.toLowerCase() == display.toLowerCase() ) {
            index = indexInArray
            return false
          }
        })
        return index
      } else {
        return $.inArray(value, this.realvalues)
      }
    }
  , createBadge: function ( value) {
    var that = this
    var display = value;
    var tag = '';
    if (value.match('--')){
      var str = value.split('--');
      display = str[1];
      tag = {
        id: str[0],
        name: str[1]
      }
    }
    
    if (value.match('--') && (tag.id).match('cat')) {
      var p = $('<span/>', {
        'class' : "tag label pull-right label-info",
        'data-id': tag.id,
        'style': "margin: 2px 1px; padding:2px 3px;"
      })
      .text(display.toString())
      $('#contentTags').prepend($(p));

      //.insertAfter(that.element)
    }
    else if ( value.match('--') && (tag.id).match('typ')) {
      var p = $('<span/>', {
        'class' : "tag label pull-right label-success",
        'data-id': tag.id, 
        'style': "margin: 2px 1px; padding:2px 3px;"

      })
      .text(display.toString())
      //.insertAfter(that.element)
      $('#contentTags').prepend($(p));
    }
    else {
      if (!value.match('--')){
       tag = CE.communications.addTag(value);
      }
        var p = $('<span/>', {
          'class' : "tag label pull-right label-warning",
          'data-id': tag.id,
          'style': "margin: 2px 1px; padding:2px 3px;"
        })
        .text(display.toString())
        .append($('<button type="button" class="  close">&times;</button>')
          .on('click', function () {
            that.remove(that.element.siblings('.tag').index($(this).closest('.tag')))
          })
        )
        //.insertAfter(that.element)
        //console.log(p);
        $('#contentTags').append($(p));
        //.insertBefore(that.element)

    }
  }
  , add: function ( value ) {
      var that = this
      if (value.match('--')){
        var str = value.split('--');
        value  = str[1];
      }

      if ( !that.options.allowDuplicates ) {
        var index = that.inValues(value);

        if ( index != -1 ) {
          index++;
          var badge = that.element.siblings('.tag:nth-last-child(' + index + ')')

          badge.addClass('tag-warning')
          setTimeout(function () {
            $(badge).removeClass('tag-warning')
          }, 500)
          return
        }
      }
      
      this.values.push(value)
      this.realvalues.push(value)
      this.createBadge(value)

      this.element.val(this.values.join(', '))
      this.element.trigger('added', [value])
    }
  , remove: function ( index ) {
      if ( index >= 0 ) {
        var value = this.values.splice(index, 1)
        this.element.siblings('.tag:eq(' + index + ')').remove()
        this.element.val(this.values.join(', '))

        this.element.trigger('removed', [value])
      }
    }
  , process: function () {
      var values = $.grep($.map(this.input.val().split(','), $.trim), function ( value ) { return value.length > 0 }),
          that = this
      $.each(values, function() {
        that.add(this)
      })
      this.input.val('')
    }
  , skip: false
  }

  var old = $.fn.tag

  $.fn.tag = function ( option ) {
    return this.each(function () {
      var that = $(this)
        , data = that.data('tag')
        , options = typeof option == 'object' && option
      if (!data) that.data('tag', (data = new Tag(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.tag.defaults = {
    allowDuplicates: false
  , caseInsensitive: true
  , autocompleteOnComma: false
  , placeholder: ''
  , source: []
  }

  $.fn.tag.Constructor = Tag

  $.fn.tag.noConflict = function () {
    $.fn.tag = old
    return this
  }

  $(window).on('load', function () {
    $('[data-provide="tag"]').each(function () {
      var that = $(this)
      if (that.data('tag')) return
      that.tag(that.data())
    })
  })
}(window.jQuery)