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
                      <v-subheader>Group *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-select
                        :items="filterGroup"
                        v-model="formData.filter_group_id"
                        label="Filter Group"
                        auto
                        required
                        item-text="name"
                        item-value="id"
                        v-validate="'required'"
                        data-vv-name="Filter Group"     
                        :error-messages="errors.collect('Filter Group')"  
                      ></v-select>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Name *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Name"
                        name="name"
                        placeholder="Name"
                        v-model="formData.name"
                        v-validate="'required'"
                        data-vv-name="name"     
                        :error-messages="errors.collect('name')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Sort Order</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Sort Order"
                        name="name"
                        placeholder="Sort Order"
                        v-model="formData.sort_order"
                        data-vv-name="sort_order"
                      ></v-text-field>
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
  import {createData,editData,updateData} from '~/api/catalog/filter'
  import {fetchFilterGroupList} from '~/api/catalog/filterGroup'
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
        parent_name:'Filters',
        child_name:'Filters Form',
        routeName:'Filters',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        formData: {
          name: '',
          filter_group_id: '',
          sort_order: 0
        },
        filterGroup: [],
      };
    },
    computed: {
    }, 
    created() {
      if(this.id){
        Flash.setLoading(true)
        this.getData();
      }
      this.getFilterGroup()
    },
    methods: {
      backList(){
        this.$router.push({name:this.routeName})
      },
      getData() {
        editData(this.id).then(response => {
          console.log("data",response['data'])
          // fetch all form data
          this.formData.filter_group_id = response['data']['filter_group_id']
          this.formData.name = response['data']['name']
          this.formData.sort_order = response['data']['sort_order']
          Flash.setLoading(false)
        })
      },
      clear () {
        this.formData = {};
        this.$validator.reset();
      },
      getFilterGroup() {
        fetchFilterGroupList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['filter_group_id'],'name':response['data'][x]['name']}
            this.filterGroup.push(data)
          }
        })
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