<template>
  <div id="page-text-fields">
    <v-form ref="form" v-model="valid" lazy-validation @submit.prevent="onSubmit">
      <!--Bread Camp for form -->
      <bread-crumb
        :routeName="routeName"
        :parent_name="parent_name"
        :child_name="child_name">
      </bread-crumb>
      <!--#End Bread Camp for form -->

      <v-container grid-list-xl fluid>
        <!--toast message-->
        <message
          ref="child"
          :notifyStatus="notifyStatus"
          :message="message" > 
        ></message>
        <!--#End toast message-->
        <v-layout row wrap>
          <v-flex sm12>
            <v-widget :title="child_name" >
              <div slot="widget-content">
                <v-container>

                  <!--<v-layout row wrap>-->
                  <v-tabs text-and-icons>
                    <v-tab href="#tab-1">
                      <v-icon>home</v-icon> &nbsp; General Information
                    </v-tab>

                    <v-tab href="#tab-2">
                      <v-icon>dashboard</v-icon> &nbsp; Data
                    </v-tab>

                    <!--Tab 1-->
                    <v-tab-item id="tab-1">
                      <v-spacer></v-spacer>
                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Category Name *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Category Name"
                            name="name"
                            placeholder="Category Name"
                            v-model="formData.name"
                            v-validate="'required'"
                            data-vv-name="category name"     
                            :error-messages="errors.collect('category name')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Description *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-textarea outline
                            label="Description"
                            name="name"
                            placeholder="Description"
                            v-model="formData.description"
                            data-vv-name="Description"
                            v-validate="'required'"
                            :error-messages="errors.collect('Description')"  
                            required
                          ></v-textarea outline>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Meta Title *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Meta Title"
                            name="name"
                            placeholder="Meta Title"
                            v-model="formData.meta_title"
                            v-validate="'required'"
                            data-vv-name="Meta Title"     
                            :error-messages="errors.collect('Meta Title')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Meta Keyword *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Meta Keyword"
                            name="name"
                            placeholder="Meta Keyword"
                            v-model="formData.meta_keyword"
                            v-validate="'required'"
                            data-vv-name="Meta Keyword"     
                            :error-messages="errors.collect('Meta Keyword')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Meta Description *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-textarea outline
                            label="Meta Description"
                            name="name"
                            placeholder="Meta Description"
                            v-model="formData.meta_description"
                            data-vv-name="Meta Description"
                            v-validate="'required'"
                            :error-messages="errors.collect('Meta Description')"  
                            required
                          ></v-textarea outline>
                        </v-flex>
                      </v-layout>

                    </v-tab-item><!--#End tab 1-->

                    <!--Tab 2-->
                    <v-tab-item id="tab-2">
                      <v-spacer></v-spacer>
                      
                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Image</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <!--<div class="imgUpload">
                            <input type="file" accept="image/*" name="fileupload" v-on:change="showPreviewImage($event)"/>
                            <span v-if="imagePreview.length > 0">
                              <img width="150px" :src="imagePreview"/><br/>
                            </span>
                          </div>-->
                          <div class="box">
                            <input type="file" accept="image/*" name="fileupload" v-on:change="showPreviewImage($event)" id="file-5" class="inputfile inputfile-4" data-multiple-caption="{count} files selected" />
                            <label for="file-5"><figure><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure> <span>Choose a file&hellip;</span></label>
                            <span v-if="imagePreview.length > 0">
                              <img width="100px" :src="imagePreview"/><br/>
                            </span>
                          </div>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Parent</v-subheader>
                        </v-flex>
                          <v-flex xs6>
                            <v-select
                              :items="parents"
                              v-model="formData.parent_id"
                              label="Parent"
                              autocomplete
                              single-line
                              required
                              item-text="name"
                              item-value="id"
                            ></v-select>
                            <v-flex xs6>
                        </v-flex>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Filter *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-select
                            :items="filters"
                            v-model="formData.filter"
                            tags
                            chips
                            multiple=""
                            label="Filter"
                            class="input-group--focused"
                            item-text="name"
                            v-validate="'required'"
                            data-vv-name="filter"     
                            :error-messages="errors.collect('filter')"  
                            required
                          ></v-select>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Store *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-select
                            :items="stores"
                            v-model="formData.store"
                            tags
                            chips
                            multiple=""
                            label="Store"
                            class="input-group--focused"
                            item-text="name"
                            v-validate="'required'"
                            data-vv-name="store"     
                            :error-messages="errors.collect('store')"  
                            required
                          ></v-select>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Sort Order *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            type="number"
                            label="Sort Order"
                            name="name"
                            autocomplete = "off"
                            placeholder="Sort Order"
                            v-model="formData.sort_order"
                            v-validate="'required'"
                            data-vv-name="sort order"     
                            :error-messages="errors.collect('sort order')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Column *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            type="number"
                            label="Column"
                            name="name"
                            autocomplete = "off"
                            placeholder="Column"
                            v-model="formData.column"
                            v-validate="'required'"
                            data-vv-name="column"     
                            :error-messages="errors.collect('column')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Show Top *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-radio-group v-model="formData.top" row>
                            <v-radio
                              :key="1"
                              label="Yes"
                              :value="1"
                            ></v-radio>
                            <v-radio
                              :key="0"
                              label="No"
                              :value="0"
                            ></v-radio>
                          </v-radio-group>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Status *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-radio-group v-model="formData.status" row>
                            <v-radio
                              :key="1"
                              label="Active"
                              :value="1"
                            ></v-radio>
                            <v-radio
                              :key="0"
                              label="Inactive"
                              :value="0"
                            ></v-radio>
                          </v-radio-group>
                        </v-flex>
                      </v-layout>

                    </v-tab-item><!--#End tab 2-->

                  </v-tabs><!--#End v-layout row wrap-->

                </v-container>
              </div>
            </v-widget>
          </v-flex>
        </v-layout>
      </v-container>
    </v-form>

  </div>
</template>

<style>
  
.inputfile {
    width: 100px;
    height: 100px;
    opacity: 0 !important;
    overflow: hidden !important;
    position: absolute !important;
    z-index: -1 !important;
}

.inputfile + label {
    max-width: 80%;
    font-size: 1rem;
    /* 20px */
    font-weight: 700;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
    display: inline-block;
    overflow: hidden !important;
    /* 10px 20px */
}

.no-js .inputfile + label {
    display: none;
}

.inputfile:focus + label,
.inputfile.has-focus + label {
    outline: 1px dotted #000;
    outline: -webkit-focus-ring-color auto 5px;
}

.inputfile + label * {
    /* pointer-events: none; */
    /* in case of FastClick lib use */
}

.inputfile + label svg {
    width: 1em;
    height: 1em;
    vertical-align: middle;
    fill: currentColor;
    margin-top: -0.25em;
    /* 4px */
    margin-right: 0.25em;
    /* 4px */
}

/* style 4 */

.inputfile-4 + label {
    color: #d3394c;
}

.inputfile-4:focus + label,
.inputfile-4.has-focus + label,
.inputfile-4 + label:hover {
    color: #722040;
}

.inputfile-4 + label figure {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background-color: #d3394c;
    display: block;
    padding: 20px;
    margin: 0 auto 10px;
}

.inputfile-4:focus + label figure,
.inputfile-4.has-focus + label figure,
.inputfile-4 + label:hover figure {
    background-color: #722040;
}

.inputfile-4 + label svg {
    width: 100%;
    height: 100%;
    fill: #f1e5e6;
}


/* style 5 */

.inputfile-5 + label {
    color: #d3394c;
}

.inputfile-5:focus + label,
.inputfile-5.has-focus + label,
.inputfile-5 + label:hover {
    color: #722040;
}

.inputfile-5 + label figure {
    width: 100px;
    height: 135px;
    background-color: #d3394c;
    display: block;
    position: relative;
    padding: 30px;
    margin: 0 auto 10px;
}

.inputfile-5:focus + label figure,
.inputfile-5.has-focus + label figure,
.inputfile-5 + label:hover figure {
    background-color: #722040;
}

.inputfile-5 + label figure::before,
.inputfile-5 + label figure::after {
    width: 0;
    height: 0;
    content: '';
    position: absolute;
    top: 0;
    right: 0;
}

.inputfile-5 + label figure::before {
    border-top: 20px solid #dfc8ca;
    border-left: 20px solid transparent;
}

.inputfile-5 + label figure::after {
    border-bottom: 20px solid #722040;
    border-right: 20px solid transparent;
}

.inputfile-5:focus + label figure::after,
.inputfile-5.has-focus + label figure::after,
.inputfile-5 + label:hover figure::after {
    border-bottom-color: #d3394c;
}

.inputfile-5 + label svg {
    width: 100%;
    height: 100%;
    fill: #f1e5e6;
}
</style>

<script>
  import {fetchCategoryList, createData, editData, updateData} from '~/api/catalog/category'
  import {fetchFilterList} from '~/api/catalog/filter'
  import {fetchStoreList} from '~/api/system/store'
  import Message from '~/components/common/Message'
  import BreadCrumb from '~/components/common/BreadCrumb'
  import VWidget from '~/components/VWidget';
  import Flash from '~/services/flash'
  export default {
    props:['id'],
    $_veeValidate: {
      validator: 'new'
    },
    components: {
      VWidget,
      Message,
      BreadCrumb
    },
    data () {
      return {
        parent_name:'Option',
        child_name:'Option Form',
        routeName:'Option',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        filters: [],
        stores: [],
        parents: [],
        imagePreview: './img/NoPicture.png',
        formData: {
          name: '',
          description: '',
          meta_keyword: '',
          meta_title: '',
          meta_description: '',
          parent_id: '',
          store: '',
          filter: '',
          top: 1,
          status: 1
        },
        attributeGroup: [],
      };
    },
    computed: {
    }, 
    created() {
      if(this.id){
        Flash.setLoading(true)
        this.getData();
      }
      this.getCategory();
      this.getStore();
      this.getFilter();
    },
    methods: {
      // Upload Image 
      showPreviewImage: function(event) {
        this.formData.hidden_image = ''
        // Reference to the DOM input element
        var input = event.target;
        // Ensure that you have a file before attempting to read it
        if (input.files && input.files[0]) {
            // create a new FileReader to read this image and convert to base64 format
            var reader = new FileReader();
            // Define a callback function to run, when FileReader finishes its job
            reader.onload = (e) => {
                // Note: arrow function used here, so that "this.imagePreview" refers to the imageData of Vue component
                // Read image as base64 and set to imageData
                this.imagePreview = e.target.result;
            }
            // Start the reader job - read file as a data url (base64 format)
            reader.readAsDataURL(input.files[0]);
        }
      },
      backList(){
        this.$router.push({name:this.routeName})
      },
      getData() {
        editData(this.id).then(response => {
          // fetch all form data
          this.formData.name = response['data']['name'];
          this.formData.description = response['data']['description'];
          Flash.setLoading(false);
        })
      },
      getCategory(){
        fetchCategoryList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['category_id'],'name':response['data'][x]['name']};
            this.parents.push(data);
          }
        })
      },
      getStore(){
        fetchStoreList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['store_id'],'name':response['data'][x]['name']};
            this.stores.push(data);
          }
        })
      },
      getFilter(){
        fetchFilterList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['filter_id'],'name':response['data'][x]['name']};
            this.filters.push(data);
          }
        })
      },
      clear () {
        this.formData = {};
        this.$validator.reset();
      },
      onSubmit () {
        this.$validator.validateAll().then((result) => {
        if(!result){
          this.notifyStatus = 'error';
          this.message = 'All fields are required!';
          return false;
        }
          // If has props edit data
          if(this.id){
            updateData(this.formData,this.id).then(response => {
              if(response.success == true){
                this.notifyStatus = 'success'
                this.message = response.message
              }else{
                this.notifyStatus = 'error'
                this.message = response.message
              }
            }).catch(e => {
                this.notifyStatus = 'error'
                this.message = 'Error while trying to update data!'
            })
          }else{        
            createData(this.formData).then(response => {
              if(response.success == true){
                this.notifyStatus = 'success'
                this.message = response.message
                this.clear()
              }else{
                this.notifyStatus = 'error'
                this.message = response.message
              }
            }).catch(e => {
                this.notifyStatus = 'error'
                this.message = 'Error while trying to create data!'
            })
          }
        }).catch(() => {
        });
        
      }
    }
  };
</script>