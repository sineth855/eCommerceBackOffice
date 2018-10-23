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
                        <v-icon>settings</v-icon> &nbsp; General Setting
                      </v-tab>

                      <v-tab href="#tab-2">
                        <v-icon>local_shipping</v-icon> &nbsp; Shipping Location & Costs
                      </v-tab>

                      <v-tab href="#tab-3">
                        <v-icon>location_on</v-icon> &nbsp; Size & Weight
                      </v-tab>
                      <!--Tab 1-->
                      <v-tab-item id="tab-1">
                        <v-spacer></v-spacer>
                        <v-layout row>
                          <v-flex xs3>
                            <v-subheader>Carrier Name *</v-subheader>
                          </v-flex>
                          <v-flex xs6>
                            <v-text-field
                              label="Carrier Name"
                              name="name"
                              placeholder="Carrier Name"
                              v-model="formData.name"
                              v-validate="'required'"
                              data-vv-name="carrier name"     
                              :error-messages="errors.collect('carrier name')"  
                              required
                            ></v-text-field>
                          </v-flex>
                        </v-layout>

                        <v-layout row>
                          <v-flex xs3>
                            <v-subheader>Store *</v-subheader>
                          </v-flex>
                          <v-flex xs6>
                            <v-select
                              :items="store"
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
                            <v-subheader>Transit time *</v-subheader>
                          </v-flex>
                          <v-flex xs6>
                            <v-text-field
                              label="Transit time"
                              name="name"
                              placeholder="Delay"
                              v-model="formData.delay"
                              v-validate="'required'"
                              data-vv-name="transit time"     
                              :error-messages="errors.collect('transit time')"  
                              required
                            ></v-text-field>
                          </v-flex>
                        </v-layout>

                        <v-layout row>
                          <v-flex xs3>
                            <v-subheader>Spead Grade</v-subheader>
                          </v-flex>
                          <v-flex xs6>
                            <v-text-field
                              label="Spead Grade"
                              name="name"
                              placeholder="Spead Grade"
                              v-model="formData.grade"
                            ></v-text-field>
                          </v-flex>
                        </v-layout>

                        <v-layout row>
                          <v-flex xs3>
                            <v-subheader>Tracking URL</v-subheader>
                          </v-flex>
                          <v-flex xs6>
                            <v-text-field
                              label="Tracking URL"
                              type="email"
                              name="name"
                              placeholder="Tracking URL"
                              v-model="formData.url"
                              v-validate="'required'"
                              data-vv-name="Tracking URL"     
                              :error-messages="errors.collect('Tracking URL')"  
                              required
                            ></v-text-field>
                          </v-flex>
                        </v-layout>

                        <v-layout row>
                          <v-flex xs3>
                            <v-subheader>Active</v-subheader>
                          </v-flex>
                          <v-flex xs6>
                            <v-radio-group v-model="formData.active" row>
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

                      </v-tab-item>

                      <!--Tab 2-->

                      <v-tab-item id="tab-2">
                        <v-spacer></v-spacer>
                        <v-layout row>
                          <v-flex xs3>
                            <v-subheader>Free Shipping</v-subheader>
                          </v-flex>
                          <v-flex xs6>
                            <v-radio-group v-model="formData.is_free" row>
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
                            <v-subheader>Range Price</v-subheader>
                          </v-flex>
                          <v-flex xs6>
                            <v-text-field
                              label="Price Range From"
                              name="name"
                              placeholder="Price Range From"
                              v-model="formData.delimiter1"
                            ></v-text-field>
                            
                            <v-text-field
                              label="Price Range To"
                              name="name"
                              placeholder="Price Range To"
                              v-model="formData.delimiter2"
                            ></v-text-field>

                          </v-flex>
                        </v-layout>

                        <v-layout row>
                          <v-flex xs3>
                            <v-subheader>Allow Zone</v-subheader>
                          </v-flex>
                          <v-flex xs6>
                            <v-select
                              :items="zoneData"
                              v-model="formData.zone"
                              tags
                              chips
                              multiple=""
                              label="Zone"
                              class="input-group--focused"
                              item-text="name"
                            ></v-select>
                          </v-flex>
                        </v-layout>
                      </v-tab-item>

                      <!--Tab 3-->
                      <v-tab-item id="tab-3">
                        <v-spacer></v-spacer>
                        <v-layout row>
                          <v-flex xs3>
                            <v-subheader>Maximum package width (cm)</v-subheader>
                          </v-flex>
                          <v-flex xs6>
                            <v-text-field
                              label="Maximum package width (cm)"
                              name="name"
                              placeholder=""
                              v-model="formData.max_width"
                              v-validate="'required'"
                              data-vv-name="max width"     
                              :error-messages="errors.collect('max width')"  
                              required
                            ></v-text-field>
                          </v-flex>
                        </v-layout>

                        <v-layout row>
                          <v-flex xs3>
                            <v-subheader>Maximum package height (cm)</v-subheader>
                          </v-flex>
                          <v-flex xs6>
                            <v-text-field
                              label="Maximum package height (cm)"
                              name="name"
                              v-model="formData.max_height"
                              v-validate="'required'"
                              data-vv-name="Maximum package"     
                              :error-messages="errors.collect('Maximum package')"  
                              required
                            ></v-text-field>
                          </v-flex>
                        </v-layout>

                        <v-layout row>
                          <v-flex xs3>
                            <v-subheader>Maximum package depth (cm)</v-subheader>
                          </v-flex>
                          <v-flex xs6>
                            <v-text-field
                              label="Maximum package depth (cm)"
                              name="name"
                              v-model="formData.max_depth"
                              v-validate="'required'"
                              data-vv-name="Maximum package depth"     
                              :error-messages="errors.collect('Maximum package depth')"  
                              required
                            ></v-text-field>
                          </v-flex>
                        </v-layout>

                        <v-layout row>
                          <v-flex xs3>
                            <v-subheader>Maximum package weight (kg)</v-subheader>
                          </v-flex>
                          <v-flex xs6>
                            <v-text-field
                              label="Maximum package weight (kg)"
                              name="name"
                              v-model="formData.max_weight"
                              v-validate="'required'"
                              data-vv-name="Maximum package weight"     
                              :error-messages="errors.collect('Maximum package weight')"  
                              required
                            ></v-text-field>
                          </v-flex>
                        </v-layout>

                      </v-tab-item>
                    </v-tabs>
                  <!--</v-layout>-->
         
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
  import {createData,editData,updateData} from '~/api/shipping/carrier'
  import {fetchZoneList} from '~/api/system/zone'
  import {fetchStoreList} from '~/api/system/store'
  import Countries  from '~/api/country';
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
        parent_name:'Carriers',
        child_name:'Carriers Form',
        routeName:'Carriers',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        zoneData: [],
        store: [],
        formData: {
          name: '',
          active: 1,
          delay: '',
          grade: '',
          url: '',
          is_free: 0,
          delimiter1: 0,
          delimiter2: 0,
          zone: '',
          max_width: '',
          max_height: '',
          max_depth: '',
          max_weight: ''
        }
      };
    },
    computed: {
    }, 
    created() {
      this.getZone()
      this.getStore()
      if(this.id){
        Flash.setLoading(true)
        this.getData();
      }
    },
    methods: {
      backList(){
        this.$router.push({name:this.routeName})
      },
      getZone(){
        fetchZoneList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'zone_id':response['data'][x]['zone_id'],'name':response['data'][x]['name']}
            this.zoneData.push(data)
          }
        })
      },
      getStore(){
        fetchStoreList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'store_id':response['data'][x]['store_id'],'name':response['data'][x]['name']}
            this.store.push(data)
          }
        })
      },
      getData() {
        editData(this.id).then(response => {
          // fetch all form data
          this.formData.name = response['data']['name']
          this.formData.delay = response['data']['delay']
          this.formData.active = response['data']['active']
          this.formData.grade = response['data']['grade']
          this.formData.url = response['data']['url']
          this.formData.is_free = response['data']['is_free']
          this.formData.delimiter1 = response['data']['range_price']['delimiter1']
          this.formData.delimiter2 = response['data']['range_price']['delimiter2']
          this.formData.zone = response['data']['zone']
          this.formData.store = response['data']['store']
          this.formData.max_width = response['data']['max_width']
          this.formData.max_height = response['data']['max_height']
          this.formData.max_depth = response['data']['max_depth']
          this.formData.max_weight = response['data']['max_weight']
          Flash.setLoading(false)
        })
      },
      clear () {
        this.formData = {};
        this.$validator.reset();
      },
      onSubmit () {
        console.log(this.formData);
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