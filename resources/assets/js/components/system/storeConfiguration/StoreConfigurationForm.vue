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
                      <v-icon>settings</v-icon> &nbsp; Store Configuration
                    </v-tab>

                    <!--tab 1-->
                    <v-tab-item id="tab-1">
                      <v-spacer></v-spacer>
                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Store Name *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Store Name"
                            name="name"
                            placeholder="Store Name"
                            v-model="formData.name"
                            v-validate="'required'"
                            data-vv-name="Store Name"     
                            :error-messages="errors.collect('Store Name')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>URL *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="URL"
                            name="name"
                            placeholder="URL"
                            v-model="formData.url"
                            v-validate="'required'"
                            data-vv-name="URL"     
                            :error-messages="errors.collect('URL')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>SSL *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="SSL"
                            name="name"
                            placeholder="SSL"
                            v-model="formData.ssl"
                            v-validate="'required'"
                            data-vv-name="SSL"     
                            :error-messages="errors.collect('SSL')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>
                      
                      <v-layout row>
                          <v-flex xs3>
                            <v-subheader>Default *</v-subheader>
                          </v-flex>
                          <v-flex xs6>
                            <v-radio-group v-model="formData.is_default" row>
                              <v-radio
                                :key="0"
                                label="Yes"
                                :value="0"
                              ></v-radio>
                              <v-radio
                                :key="1"
                                label="No"
                                :value="1"
                              ></v-radio>
                            </v-radio-group>
                          </v-flex>
                        </v-layout>

                    </v-tab-item><!--#End tab 1-->

                    <!--tab 2-->
                    <v-tab-item id="tab-2">
                      <v-spacer></v-spacer>
                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Address *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Address"
                            name="name"
                            placeholder="Address"
                            v-model="formData.config_address"
                            v-validate="'required'"
                            data-vv-name="address"     
                            :error-messages="errors.collect('address')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Cart Weight *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Cart Weight"
                            name="name"
                            placeholder="Cart Weight"
                            v-model="formData.config_cart_weight"
                            v-validate="'required'"
                            data-vv-name="Cart Weight"     
                            :error-messages="errors.collect('Cart Weight')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Checkout Guest *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Checkout Guest"
                            name="name"
                            placeholder="Checkout Guest"
                            v-model="formData.config_checkout_guest"
                            v-validate="'required'"
                            data-vv-name="Checkout Guest"     
                            :error-messages="errors.collect('Checkout Guest')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Checkout ID *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Checkout ID"
                            name="name"
                            placeholder="Checkout ID"
                            v-model="formData.config_checkout_guest"
                            v-validate="'required'"
                            data-vv-name="Checkout ID"     
                            :error-messages="errors.collect('Checkout ID')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Comment *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Comment"
                            name="name"
                            placeholder="Comment"
                            v-model="formData.config_comment"
                            v-validate="'required'"
                            data-vv-name="Comment"     
                            :error-messages="errors.collect('Comment')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Country ID *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Country ID"
                            name="name"
                            placeholder="Country ID"
                            v-model="formData.config_country_id"
                            v-validate="'required'"
                            data-vv-name="Country ID"     
                            :error-messages="errors.collect('Country ID')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Currency *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Currency"
                            name="name"
                            placeholder="Currency"
                            v-model="formData.config_currency"
                            v-validate="'required'"
                            data-vv-name="Currency"     
                            :error-messages="errors.collect('Currency')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Customer Group ID *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Customer Group ID"
                            name="name"
                            placeholder="Customer Group ID"
                            v-model="formData.config_customer_group_id"
                            v-validate="'required'"
                            data-vv-name="Customer Group ID"     
                            :error-messages="errors.collect('Customer Group ID')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Customer Price *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Customer Price"
                            name="name"
                            placeholder="Customer Price"
                            v-model="formData.config_customer_price"
                            v-validate="'required'"
                            data-vv-name="Customer Price"     
                            :error-messages="errors.collect('Customer Price')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Email *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Email"
                            name="name"
                            placeholder="Config Email"
                            v-model="formData.config_email"
                            v-validate="'required'"
                            data-vv-name="Config Email"     
                            :error-messages="errors.collect('Config Email')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Fax *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Fax"
                            name="name"
                            placeholder="Config Fax"
                            v-model="formData.config_fax"
                            v-validate="'required'"
                            data-vv-name="Config Fax"     
                            :error-messages="errors.collect('Config Fax')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config GEO Code *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config GEO Code"
                            name="name"
                            placeholder="Config GEO Code"
                            v-model="formData.config_geocode"
                            v-validate="'required'"
                            data-vv-name="Config GEO Code"     
                            :error-messages="errors.collect('Config GEO Code')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Icon *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Icon"
                            name="name"
                            placeholder="Config Icon"
                            v-model="formData.config_icon"
                            v-validate="'required'"
                            data-vv-name="Config Icon"     
                            :error-messages="errors.collect('Config Icon')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Image *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Image"
                            name="name"
                            placeholder="Config Image"
                            v-model="formData.config_image"
                            v-validate="'required'"
                            data-vv-name="Config Image"     
                            :error-messages="errors.collect('Config Image')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Language *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Language"
                            name="name"
                            placeholder="Config Language"
                            v-model="formData.config_language"
                            v-validate="'required'"
                            data-vv-name="Config Language"     
                            :error-messages="errors.collect('Config Language')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Language ID *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Language ID"
                            name="name"
                            placeholder="Config Language ID"
                            v-model="formData.config_language_id"
                            v-validate="'required'"
                            data-vv-name="Config Language ID"     
                            :error-messages="errors.collect('Config Language ID')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Layout ID *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Layout ID"
                            name="name"
                            placeholder="Config Layout ID"
                            v-model="formData.config_layout_id"
                            v-validate="'required'"
                            data-vv-name="Config Layout ID"     
                            :error-messages="errors.collect('Config Layout ID')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Logo *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Logo"
                            name="name"
                            placeholder="Config Logo"
                            v-model="formData.config_logo"
                            v-validate="'required'"
                            data-vv-name="Config Logo"     
                            :error-messages="errors.collect('Config Logo')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Meta Description *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Meta Description"
                            name="name"
                            placeholder="Config Meta Description"
                            v-model="formData.config_meta_description"
                            v-validate="'required'"
                            data-vv-name="Config Meta Description"     
                            :error-messages="errors.collect('Config Meta Description')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Meta Keyword *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Meta Keyword"
                            name="name"
                            placeholder="Config Meta Keyword"
                            v-model="formData.config_meta_keyword"
                            v-validate="'required'"
                            data-vv-name="Config Meta Keyword"     
                            :error-messages="errors.collect('Config Meta Keyword')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Meta Title *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Meta Title"
                            name="name"
                            placeholder="Config Meta Title"
                            v-model="formData.config_meta_title"
                            v-validate="'required'"
                            data-vv-name="Config Meta Title"     
                            :error-messages="errors.collect('Config Meta Title')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Name *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Name"
                            name="name"
                            placeholder="Config Name"
                            v-model="formData.config_name"
                            v-validate="'required'"
                            data-vv-name="Config Name"     
                            :error-messages="errors.collect('Config Name')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Open *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Open"
                            name="name"
                            placeholder="Config Open"
                            v-model="formData.config_open"
                            v-validate="'required'"
                            data-vv-name="Config Open"     
                            :error-messages="errors.collect('Config Open')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Order Status ID *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Order Status ID"
                            name="name"
                            placeholder="Config Order Status ID"
                            v-model="formData.config_order_status_id"
                            v-validate="'required'"
                            data-vv-name="Config Order Status ID"     
                            :error-messages="errors.collect('Config Order Status ID')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Owner *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Owner"
                            name="name"
                            placeholder="Config Owner"
                            v-model="formData.config_owner"
                            v-validate="'required'"
                            data-vv-name="Config Owner"     
                            :error-messages="errors.collect('Config Owner')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Review Status *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Review Status"
                            name="name"
                            placeholder="Config Review Status"
                            v-model="formData.config_review_status"
                            v-validate="'required'"
                            data-vv-name="Config Review Status"     
                            :error-messages="errors.collect('Config Review Status')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Secure *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Secure"
                            name="name"
                            placeholder="Config Secure"
                            v-model="formData.config_secure"
                            v-validate="'required'"
                            data-vv-name="Config Secure"     
                            :error-messages="errors.collect('Config Secure')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config SSL *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config SSL"
                            name="name"
                            placeholder="Config SSL"
                            v-model="formData.config_ssl"
                            v-validate="'required'"
                            data-vv-name="Config SSL"     
                            :error-messages="errors.collect('Config SSL')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Stock Checkout *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Stock Checkout"
                            name="name"
                            placeholder="Config Stock Checkout"
                            v-model="formData.config_stock_checkout"
                            v-validate="'required'"
                            data-vv-name="Config Stock Checkout"     
                            :error-messages="errors.collect('Config Stock Checkout')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Stock Display *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Stock Display"
                            name="name"
                            placeholder="Config Stock Display"
                            v-model="formData.config_stock_display"
                            v-validate="'required'"
                            data-vv-name="Config Stock Display"     
                            :error-messages="errors.collect('Config Stock Display')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Tax *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Tax"
                            name="name"
                            placeholder="Config Tax"
                            v-model="formData.config_tax"
                            v-validate="'required'"
                            data-vv-name="Config Tax"     
                            :error-messages="errors.collect('Config Tax')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Tax Customer *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Tax Customer"
                            name="name"
                            placeholder="Config Tax Customer"
                            v-model="formData.config_tax_customer"
                            v-validate="'required'"
                            data-vv-name="Config Tax Customer"     
                            :error-messages="errors.collect('Config Tax Customer')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Tax Default *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Tax Default"
                            name="name"
                            placeholder="Config Tax Default"
                            v-model="formData.config_tax_default"
                            v-validate="'required'"
                            data-vv-name="Config Tax Default"     
                            :error-messages="errors.collect('Config Tax Default')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Theme *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Theme"
                            name="name"
                            placeholder="Config Theme"
                            v-model="formData.config_theme"
                            v-validate="'required'"
                            data-vv-name="Config Theme"     
                            :error-messages="errors.collect('Config Theme')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config URL *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config URL"
                            name="name"
                            placeholder="Config URL"
                            v-model="formData.config_url"
                            v-validate="'required'"
                            data-vv-name="Config URL"     
                            :error-messages="errors.collect('Config URL')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Config Zone ID *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Config Zone ID"
                            name="name"
                            placeholder="Config Zone ID"
                            v-model="formData.config_zone_id"
                            v-validate="'required'"
                            data-vv-name="Config Zone ID"     
                            :error-messages="errors.collect('Config Zone ID')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>
                      
                    </v-tab-item>
                    <!--#End tab2-->
                  </v-tabs><!--#End Tab-->
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
  import {createData,editData,updateData} from '~/api/system/store'
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
        parent_name:'Store Configuration',
        child_name:'Store Configuration Form',
        routeName:'Store Configuration',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        store: [],
        formData: {
          name: '',
          url: '',
          ssl: '',
          is_default: 0,
          config_account_id: 0,
          config_address: 'address',
          config_cart_weight: 0,
          config_checkout_guest: 0,
          config_checkout_id: 0,
          config_comment: 'comment',
          config_country_id: 0,
          config_currency: 0,
          config_customer_group_id: 0,
          config_customer_price: 0,
          config_email: 'email',
          config_fax: 0,
          config_geocode: 0,
          config_icon: 'icon',
          config_image: 'image',
          config_language_id: 0,
          config_language: 'en-gb',
          config_layout_id: 0,
          config_logo: 0,
          config_meta_description: 0,
          config_meta_keyword: 0,
          config_meta_title: 0,
          config_name: 0,
          config_open: 0,
          config_order_status_id: 0,
          config_owner: 0,
          config_review_status: 0,
          config_secure: 0,
          config_ssl: 0,
          config_stock_checkout: 0,
          config_stock_display: 0,
          config_store_id: 0,
          config_tax: 0,
          config_tax_customer: 0,
          config_tax_default: 0,
          config_theme: 'defult',
          config_url: 'http://test.localhost:81/openCart302/reseller1',
          config_zone_id: 588
        }
      };
    },
    computed: {
    }, 
    created() {
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
          this.formData.name = response['data']['store']['name']
          this.formData.url = response['data']['store']['url']
          this.formData.ssl = response['data']['store']['ssl']
          this.formData.is_default = response['data']['store']['is_default']
          this.formData.config_account_id = response['data']['dataSettings'][0]['config_account_id']
          this.formData.config_address = response['data']['dataSettings'][1]['config_address']
          this.formData.config_cart_weight = response['data']['dataSettings'][2]['config_cart_weight']
          this.formData.config_checkout_guest = response['data']['dataSettings'][3]['config_checkout_guest']
          this.formData.config_checkout_id = response['data']['dataSettings'][4]['config_checkout_id']
          this.formData.config_comment = response['data']['dataSettings'][5]['config_comment']
          this.formData.config_country_id = response['data']['dataSettings'][6]['config_country_id']
          this.formData.config_currency = response['data']['dataSettings'][7]['config_currency']
          this.formData.config_customer_group_id = response['data']['dataSettings'][8]['config_customer_group_id']
          this.formData.config_customer_price = response['data']['dataSettings'][9]['config_customer_price']
          this.formData.config_email = response['data']['dataSettings'][10]['config_email']
          this.formData.config_fax = response['data']['dataSettings'][11]['config_fax']
          this.formData.config_geocode = response['data']['dataSettings'][12]['config_geocode']
          this.formData.config_icon = response['data']['dataSettings'][13]['config_icon']
          this.formData.config_image = response['data']['dataSettings'][14]['config_image']
          this.formData.config_language_id = response['data']['dataSettings'][15]['config_language_id']
          this.formData.config_language = response['data']['dataSettings'][16]['config_language']
          this.formData.config_layout_id = response['data']['dataSettings'][17]['config_layout_id']
          this.formData.config_logo = response['data']['dataSettings'][18]['config_logo']
          this.formData.config_meta_description = response['data']['dataSettings'][19]['config_meta_description']
          this.formData.config_meta_keyword = response['data']['dataSettings'][20]['config_meta_keyword']
          this.formData.config_meta_title = response['data']['dataSettings'][21]['config_meta_title']
          this.formData.config_name = response['data']['dataSettings'][22]['config_name']
          this.formData.config_open = response['data']['dataSettings'][23]['config_open']
          this.formData.config_order_status_id = response['data']['dataSettings'][24]['config_order_status_id']
          this.formData.config_owner = response['data']['dataSettings'][25]['config_owner']
          this.formData.config_review_status = response['data']['dataSettings'][26]['config_review_status']
          this.formData.config_secure = response['data']['dataSettings'][27]['config_secure']
          this.formData.config_ssl = response['data']['dataSettings'][28]['config_ssl']
          this.formData.config_stock_checkout = response['data']['dataSettings'][29]['config_stock_checkout']
          this.formData.config_stock_display = response['data']['dataSettings'][30]['config_stock_display']
          this.formData.config_store_id = response['data']['dataSettings'][31]['config_store_id']
          this.formData.config_tax = response['data']['dataSettings'][32]['config_tax']
          this.formData.config_tax_customer = response['data']['dataSettings'][33]['config_tax_customer']
          this.formData.config_tax_default = response['data']['dataSettings'][34]['config_tax_default']
          this.formData.config_theme = response['data']['dataSettings'][35]['config_theme']
          this.formData.config_url = response['data']['dataSettings'][36]['config_url']
          this.formData.config_zone_id = response['data']['dataSettings'][37]['config_zone_id']
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