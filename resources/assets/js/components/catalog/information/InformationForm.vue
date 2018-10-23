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

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Store *</v-subheader>
                    </v-flex>
                      <v-flex xs6>
                        <v-select
                          :items="store"
                          v-model="formData.store_id"
                          label="Store"
                          autocomplete
                          single-line
                          required
                          item-text="name"
                          item-value="id"
                          v-validate="'required'"
                          data-vv-name="store"     
                          :error-messages="errors.collect('store')"  
                        ></v-select>
                        <v-flex xs6>
                    </v-flex>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Title *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Title"
                        name="name"
                        placeholder="Title"
                        v-model="formData.title"
                        v-validate="'required'"
                        data-vv-name="title"     
                        :error-messages="errors.collect('title')"  
                        required
                      ></v-text-field>
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
                      <v-subheader>Meta Description</v-subheader>
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

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Description</v-subheader>
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
                      <v-subheader>Sort Order *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        type="number"
                        label="Sort Order"
                        name="name"
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
                      <v-subheader>Status *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-radio-group v-model="formData.status" row>
                        <v-radio
                          :key="1"
                          label="Enable"
                          :value="1"
                        ></v-radio>
                        <v-radio
                          :key="0"
                          label="Disable"
                          :value="0"
                        ></v-radio>
                      </v-radio-group>
                    </v-flex>
                  </v-layout>
         
                </v-container>
              </div>
            </v-widget>
          </v-flex>
        </v-layout>
      </v-container>
    </v-form>

  </div>
</template>

<script>
  import {createData,editData,updateData} from '~/api/catalog/information'
  import Countries  from '~/api/country';
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
        parent_name:'Information',
        child_name:'Information Form',
        routeName:'Information',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        store: [],
        formData: {
          store_id: '',
          title: '',
          description: '',
          meta_title: '',
          meta_description: '',
          meta_keyword: '',
          sort_order: 0,
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
        this.getData()
      }
      this.getStore()
    },
    methods: {
      backList(){
        this.$router.push({name:this.routeName})
      },
      getStore(){
        fetchStoreList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['store_id'],'name':response['data'][x]['name']}
            this.store.push(data)
          }
        })
      },
      getData() {
        editData(this.id).then(response => {
          console.log("data",response['data'])
          // fetch all form data
          this.formData.store_id = response['data']['store_id'];
          this.formData.title = response['data']['title'];
          this.formData.description = response['data']['description'];
          this.formData.meta_title = response['data']['meta_title'];
          this.formData.meta_description = response['data']['meta_description'];
          this.formData.meta_keyword = response['data']['meta_keyword'];
          this.formData.sort_order = response['data']['sort_order'];
          this.formData.status = response['data']['status'];
          Flash.setLoading(false)
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