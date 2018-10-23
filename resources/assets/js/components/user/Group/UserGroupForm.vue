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
                      <v-subheader>Group Name *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Group Name"
                        name="name"
                        placeholder="Group Name"
                        v-model="formData.name"
                        v-validate="'required'"
                        data-vv-name="group name"     
                        :error-messages="errors.collect('group name')"  
                        required
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
  import {createData,editData,updateData} from '~/api/user/Group'
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
        parent_name:'User Groups',
        child_name:'User Groups Form',
        routeName:'User Groups',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        formData: {
          name: ''
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
          // fetch all form data
          this.formData.name = response['data']['name']
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
          this.notifyStatus = 'error'
          this.message = 'All fields are required!'
          return false
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