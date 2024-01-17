yukon_contact_list = {
  init: function () {
    var a = $('.contact_list');
    a.shuffle({
      itemSelector: '.contact_item'
    });
    $('#contactList_sort').prop('selectedIndex', 0).on('change', function () {
      var b = this.value,
      c = {
      };
      'company' === b ? c = {
        by: function (a) {
          return a.data('company')
        }
      }
       : 'company_desc' === b ? c = {
        reverse: !0,
        by: function (a) {
          return a.data('company').toLowerCase()
        }
      }
       : 'name' === b ? c = {
        by: function (a) {
          return a.data('name').toLowerCase()
        }
      }
       : 'name_desc' === b && (c = {
        reverse: !0,
        by: function (a) {
          return a.data('name').toLowerCase()
        }
      });
      a.shuffle('sort', c)
    });
    $('#contactList_filter').prop('selectedIndex', 0).on('change', function () {
      a.shuffle('shuffle', this.value);
      $('#contactList_sort').prop('selectedIndex', 0);
      $('#contactList_search').val('')
    });
    $('#contactList_search').val('').on('keyup', function () {
      var b = this.value;
      1 < b.length ? ($('#contactList_filter, #contactList_sort').prop('selectedIndex', 0), a.shuffle('shuffle', function (a, d) {
        return 0 <= a.data('name').toLowerCase().indexOf(b.toLowerCase())
      }))  : a.shuffle('shuffle', $('#contactList_filter').val())
    })
  }
};