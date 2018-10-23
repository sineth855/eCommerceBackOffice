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
                        :items="attributeGroup"
                        v-model="formData.attribute_group_id"
                        label="Attribute Group"
                        auto
                        required
                        item-text="name"
                        item-value="id"
                        v-validate="'required'"
                        data-vv-name="Attribute Group"     
                        :error-messages="errors.collect('Attribute Group')"  
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
  import {createData,editData,updateData} from '~/api/catalog/attribute'
  import {fetchAttributeGroupList} from '~/api/catalog/attributeGroup'
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
        parent_name:'Attribute',
        child_name:'Attribute Form',
        routeName:'Attribute',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        formData: {
          name: '',
          attribute_group_id: '',
          sort_order: 0
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
      this.getAttributeGroup()
    },
    methods: {
      backList(){
        this.$router.push({name:this.routeName})
      },
      getData() {
        editData(this.id).then(response => {
          console.log("data",response['data'])
          // fetch all form data
          this.formData.attribute_group_id = response['data']['attribute_group_id']
          this.formData.name = response['data']['name']
          this.formData.sort_order = response['data']['sort_order']
          Flash.setLoading(false)
        })
      },
      getAttributeGroup() {
        fetchAttributeGroupList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['attribute_group_id'],'name':response['data'][x]['name']}
            this.attributeGroup.push(data)
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