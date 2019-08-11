<template>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">

          <table class="table table-striped table-bordered panel-body" v-show="showParentAddAction && selectedItems.length == 0">
                <thead>
                    <tr>
                        <th>النوع</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select2 name="parent_code" :options="parentItemsOptions" v-model="selectedParentItem">
                             </select2>
                        </td>
                    </tr>
                </tbody>
            </table>


            <table class="table table-striped table-bordered panel-body">
                <thead>
                    <tr>
                        <th>الوصف</th>
                        <th>العدد المطلوب</th>
                        <th v-show="isQtySelectionStep">العدد المحدد</th>
                         
                        <th v-show="!isQtySelectionStep"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="!isQtySelectionStep">
                        <td>
                            <select2 :options="subItemsOptions" v-model="selectedSubItem">
                            </select2>
                        </td>
                        <td>
                            <input type="number" v-model="itemQty" class="form-control">
                        </td>
                        <td>
                            <button type="button" class="btn btn-success" v-on:click="addItem()">
                                <i class="fa fa-plus"></i>
                            </button>
                        </td>
                    </tr>

                     <tr v-for="(item, index) in selectedItems" :key="item.item_no">
                      <td>
                        <span v-show="!item.isEditing">
                           {{ item.store_name }} - {{ item.item_desc }}
                        </span>

                        <span v-show="item.isEditing">
                          <select2 :id="'edit-sub-item-desc-' + index" :options="item.parent.sub_items" v-model="item.item_no">
                          </select2>
                        </span>

                        <input v-if="!isQtySelectionStep" type="hidden" :name="'selected_items[' + index + '][item_id]'" :value="item.item_no">
                        <input v-if="!isQtySelectionStep" type="hidden" :name="'selected_items[' + index + '][requested_qty]'" :value="item.requested_qty">
                      </td>

                      <td>
                          <span v-show="!item.isEditing">
                             {{item.requested_qty}}
                           </span>

                           <span v-show="item.isEditing">
                                <input type="number" v-model="item.requested_qty" class="form-control">
                           </span>
                      </td>

                      <td v-if="isQtySelectionStep">
                        <input type="number"
                               :name="'selected_items[' + item.id + '][selected_qty]'" 
                               :value="item.selected_qty" 
                               class="form-control need-request-selected-qty-input">
                      </td>

                      <td v-show="!isQtySelectionStep">

                        <span v-show="item.isEditing != true">
                          <button type="button" class="btn btn-danger" @click="detachItem(item)">
                            {{trans('messages.action_delete')}}
                          </button>
                          <!-- <button type="button" class="btn btn-success" v-on:click="editItem(item)">
                            {{ trans('messages.action_edit') }}
                          </button> -->
                        </span>
                        <!-- <span v-show="item.isEditing">
                          <button type="button" class="btn btn-success" v-on:click="updateItem(item, item.parent.sub_items)">
                             حفظ
                          </button>
                        </span> -->

                      </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-2">
        </div>

        <input type="hidden" name="selected_items_old" :value="JSON.stringify(selectedItems)">
    </div>
</template>

<script>
  export default {
    props: {
      itemsIndexUrl: String,
      requestItemsUrl: String,
      isNew: String,
      selectedItemsOld: String,
      isQtySelectionStep: String,
      showParentAddAction: String,
    },
    mounted() {
        this.setParentItems();
        this.loadItems();
    },
    data() {
      return {
        selectedParentItem: 0,
        parentItemsOptions: [],

        selectedSubItem: null,
        subItemsOptions: [],

        itemQty: null,

        options: [],
        isLoading: false,
        selectedItems: [],
        deletedItems: []
      };
    },
    watch: {
        selectedParentItem(item) {
            this.setSubItems();
        }
    },
    methods: {

      setParentItems() {
        axios.get(this.itemsIndexUrl).then(response => {
            var data = [];
            
            data.push({ id: 0, text: "" });

            response.data.forEach((item, index) => {
                var sub_items = [];

                item.sub_items.forEach((subItem, subIndex) => {
                    sub_items.push({ id: subItem.item_no, text: subItem.item_desc});
                });
                // data.push({ id: item.item_no, text: item.item_desc, sub_items: sub_items });

                data.push({ id: item.parent_code, text: item.store_name, sub_items });
            });

            this.parentItemsOptions = data;
        });
      },

      setSubItems() {
          axios.get(this.itemsIndexUrl + '/' + this.selectedParentItem).then(response => {
            var data = [];
            
            data.push({ id: 0, text: "" });
            response.data.sub_items.forEach((item, index) => {
                data.push({ id: item.item_no, text: item.item_desc, parent_code:  item.parent_code});
            });

            this.subItemsOptions = data;
        });
      },

      addItem() {
        
        var selectedSubItem = this.selectedSubItem;
        var selectedParentItem = this.selectedParentItem;

        var item = this.subItemsOptions.find(function (obj) {
          return obj.id == selectedSubItem;
        });

        var parentItem = this.parentItemsOptions.find(function (obj) {
          return obj.id == selectedParentItem;
        });


        if (item != null && this.itemQty != null) {
            var id = "New-" + this.selectedItems.length;
            var parent = { item_no: parentItem.id, item_desc: parentItem.text, sub_items: parentItem.sub_items };
            var itemObject = { 
                id: id ,
                item_no: item.id, 
                item_desc: item.text, 
                requested_qty: this.itemQty,
                store_name: parentItem.text,
                parent: parent
            };
            this.selectedItems.push(itemObject);
        }

      },

      loadItems() {
        if (typeof this.selectedItemsOld !== 'undefined' && this.selectedItemsOld.length > 0) {
          this.selectedItems = JSON.parse(this.selectedItemsOld);
        } else {
          if (this.isNew == true) {
            axios.get(this.requestItemsUrl).then(response => {
              this.selectedItems = response.data;
              this.selectedParentItem  = this.selectedItems[0].parent_code;
              this.setSelectedParentItemOption();
              this.setSubItems();
            });
          }
        }
      }, 

      setUser(item) {
        this.currentSelectedUser = item;
      },

      setMemberType(memberType) {
        this.currentSelectedMemberType = memberType;
      },

      detachItem(item) {
        var r = confirm(lodashLib.get(window.i18n, 'messages.are_you_sure'));

        if (r == true) {
          for (var i = 0; i < this.selectedItems.length; i++) {
            if (this.selectedItems[i].id == item.id) {
              this.selectedItems.splice(i, 1);
              break;
            }
          }

          this.deletedItems.push(item);
        }
      },

      editItem(item) {
        item.isEditing = true;
        this.refreshSelectedItems();
      },

      updateItem(item, subItems) {
        //var memberTypeId = $('#edit-member-type-item-' + location + item.member.id).val();
        
        var subItem = subItems.find(function (obj) {
          return obj.id == item.item_no;
        });

        // item.member_type = memberType;
        item.item_desc = subItem.text;
        item.isEditing = false;
        this.refreshSelectedItems();
      },

      refreshSelectedItems() {
        var data = this.selectedItems;
        this.selectedItems = [];
        this.selectedItems = data;
      },

      setSelectedParentItemOption() {
        //alert(this.selectedParentItem);
      },

    },
  }
</script>
