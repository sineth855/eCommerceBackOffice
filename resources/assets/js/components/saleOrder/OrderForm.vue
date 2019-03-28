<template>
  <div id="pageList">
    <!--Bread Camp for form -->
    <bread-crumb
      :routeName="routeName"
      :parent_name="parent_name"
      :child_name="child_name">
    </bread-crumb>
    <!--#End Bread Camp for form -->
    <v-container grid-list-xl fluid>
      <v-layout row wrap>
        <v-flex lg4>
          <v-layout row wrap>
          
            <!--v-flex-->
            <v-flex lg12>
              <v-card class="_mt-3">
                <!--customer detail-->
                <div class="name-card">
                  <v-card color="teal" ref="card" img="/img/static/bg/15.jpg">
                    <v-card-media v-if="showTopNav">
                      <v-layout row justify-space-between class="ma-0">
                        <v-flex xs2>
                          <v-icon color="pink">favorite</v-icon>
                        </v-flex>
                        <v-flex xs2 class="text-sm-right">
                          <v-icon>more_vert</v-icon>
                        </v-flex>
                      </v-layout>
                    </v-card-media>    
                    <v-card-text>
                      <div class="layout ma-0 align-center" :class="computeCardLayout">
                        <v-avatar :size="computeAvatarSize" color="white">
                          <img src="/img/NoPicture.png" alt="name">
                          <!--<span class="white--text headline"></span>-->
                        </v-avatar>
                        <div class="flex" :class="computeTextAlgin">
                          <div class="subheading">{{ data['lastname'] }} {{ data['firstname'] }}</div>
                          <span class="caption">{{ "Customer" }}</span>
                        </div>
                      </div>
                    </v-card-text>
                  </v-card>
                  <v-bottom-nav :value="true" color="transparent" :height="64" v-if="showBottomNav">
                    <v-btn flat color="teal" value="recent">
                      <span>Recent</span>
                      <v-icon>history</v-icon>
                    </v-btn>
                    <v-btn flat color="teal" value="favorites">
                      <span>Favorites</span>
                      <v-icon>favorite</v-icon>
                    </v-btn>
                    <v-btn flat color="teal" value="nearby">
                      <span>Nearby</span>
                      <v-icon>place</v-icon>
                    </v-btn>
                  </v-bottom-nav>   
                </div>
                <!--#End customer detail-->
                

                <v-list two-line>
                  <v-list-tile href="javascript:void(0);">
                    <v-list-tile-action>
                      <v-icon color="indigo">person</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                      <!--<v-list-tile-title>{{ data['lastname'] }} {{ data['firstname'] }}</v-list-tile-title>-->
                      <!--<v-list-tile-sub-title>Customer</v-list-tile-sub-title>-->
                      
                    </v-list-tile-content>
                    <v-autocomplete
                        :items="customers"
                        v-model="formData.customer_id"
                        label="Choose Customer"
                        single-line
                        required
                        item-text="name"
                        item-value="id"
                        v-validate="'required'" 
                        required
                      ></v-autocomplete>
                    <v-list-tile-action>
                      <v-icon>chat</v-icon>
                    </v-list-tile-action>
                  </v-list-tile>
                  <v-divider inset></v-divider>
                  <v-list-tile href="javascript:void(0);">
                    <v-list-tile-action>
                      <v-icon color="indigo">phone</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                      <v-list-tile-title>{{ data['telephone'] }}</v-list-tile-title>
                      <v-list-tile-sub-title>Mobile</v-list-tile-sub-title>
                    </v-list-tile-content>
                    <v-list-tile-action>
                      <v-icon>chat</v-icon>
                    </v-list-tile-action>
                  </v-list-tile>
                  <v-divider inset></v-divider>
                  <v-list-tile href="javascript:void(0);">
                    <v-list-tile-action>
                      <v-icon color="indigo">mail</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                      <v-list-tile-title>{{ data['email'] }}</v-list-tile-title>
                      <v-list-tile-sub-title>Personal</v-list-tile-sub-title>
                    </v-list-tile-content>
                  </v-list-tile>
                  <v-divider inset></v-divider>
                  <v-list-tile href="javascript:void(0);">
                    <v-list-tile-action>
                      <v-icon color="indigo">location_on</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                      <v-list-tile-title>{{ data['payment_address_1'] }}</v-list-tile-title>
                      <v-list-tile-sub-title>Address 1</v-list-tile-sub-title>
                    </v-list-tile-content>
                    <v-list-tile-content>
                      <v-list-tile-title>{{ data['payment_address_2'] }}</v-list-tile-title>
                      <v-list-tile-sub-title> Address 2</v-list-tile-sub-title>
                    </v-list-tile-content>
                  </v-list-tile>
                </v-list>
              </v-card>
            </v-flex><!--#End v-flex-->

          </v-layout>
        </v-flex>
        
        <!--Order-->
        <v-flex lg8>
          <v-card>
            <!--tab-->
            <v-tabs text-and-icons>
              
              <v-tab>
                <v-icon>payment</v-icon> &nbsp; Order
              </v-tab>

              <v-tab>
                <v-icon>local_shipping</v-icon> &nbsp; Shipping
                <!--<v-tooltip bottom>
                  <v-btn icon slot="activator">
                    <v-icon color="text--secondary">add</v-icon>
                  </v-btn>
                  <span>Add Shipping</span>
                </v-tooltip>-->
                <v-dialog v-model="basic.dialogShipping" persistent max-width="500px">                
                    <v-btn icon slot="activator"><v-icon color="text--secondary">add</v-icon></v-btn>
                    <v-form ref="formShipping" v-model="validShipping" lazy-validation>
                    <!--<v-form ref="form_shipping" v-model="validShipping" lazy-validation @submit.prevent="onSubmitShipment">-->
                      <v-card>
                        <v-card-title>
                          <span class="headline">Add Shipping</span>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                          <v-layout wrap>
                            <v-flex xs12 sm12 md12>
                              <v-autocomplete
                                :items="carriers"
                                v-model="formCarrier.carrier_id"
                                label="Carriers"
                                single-line
                                required
                                item-text="name"
                                item-value="name"
                                v-validate="'required'"
                                data-vv-name="carrier shipping"     
                                :error-messages="errors.collect('carrier shipping')"  
                                required
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field v-model="formCarrier.amount" v-validate="'required'" label="Amount" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field v-model="formCarrier.weight" v-validate="'required'" label="Weight" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field v-model="formCarrier.shipping_cost_tax_excl" v-validate="'required'" label="Shipping Cost Tax Exclude"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field v-model="formCarrier.shipping_cost_tax_incl" v-validate="'required'" label="Shipping Cost Tax Include"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field v-model="formCarrier.tracking_number" label="Tracking Number"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field v-model="formCarrier.expected_delivery_date" v-validate="'required'" label="Expected Delivery Date" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field v-model="formCarrier.pickup_date" v-validate="'required'" label="Pickup Date" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field v-model="formCarrier.pickup_time" v-validate="'required'" label="Pickup Time" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field v-model="formCarrier.origin_pick_up" v-validate="'required'" label="Origin Pick Up" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm12 md12>
                              <v-text-field v-model="formCarrier.destination" v-validate="'required'" label="Destination" required></v-text-field>
                            </v-flex>
                          </v-layout>
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="blue darken-1" flat @click.native="basic.dialogShipping = false">Close</v-btn>
                          <v-btn type="button" @click="addShipment()" color="blue darken-1" flat>Save</v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-form>
                </v-dialog>
              </v-tab>

              <v-tab>
                <v-icon>money</v-icon> &nbsp; Payment
                <!--<v-tooltip bottom>
                  <v-btn icon slot="activator">
                    <v-icon color="text--secondary">add</v-icon>
                  </v-btn>
                  <span>Add more payment</span>
                </v-tooltip>-->
                <message
                        ref="child"
                        :notifyStatus="notifyStatus"
                        :message="message" ></message>
                <v-dialog v-model="basic.dialogPayment" persistent max-width="500px">                
                    <v-btn icon slot="activator"><v-icon color="text--secondary">add</v-icon></v-btn>
                    <v-form ref="form" v-model="valid" lazy-validation @submit.prevent="onSubmitPayment">
                      <v-card>
                        <v-card-title>
                          <span class="headline">Add Payment</span>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                          <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 sm12 md12>
                                  <!--<v-text-field v-model="formPayment.date" label="Date" required></v-text-field>-->
                                </v-flex>
                                <v-flex xs12 sm12 md12>
                                  <v-menu
                                    class="pr-2"
                                    ref="statAvailableDate"
                                    lazy
                                    :close-on-content-click="false" 
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    :nudge-bottom="-22"
                                    max-width="290px"
                                    v-model="availableDate"
                                  >
                                    <v-text-field
                                      slot="activator"
                                      label="Payment Date"
                                      v-model="formPayment.date"
                                      append-icon="event"
                                      readonly
                                      v-validate="'required'"
                                      data-vv-name="date available"     
                                      :error-messages="errors.collect('date available')"  
                                      required
                                    ></v-text-field>
                                    <v-date-picker v-model="formPayment.date" no-title scrollable>
                                      <v-spacer></v-spacer>
                                      <v-btn flat color="primary" @click="availableDate = false">Cancel</v-btn>
                                      <v-btn flat color="primary" @click="$refs.statAvailableDate.save(formPayment.date)">OK</v-btn>
                                    </v-date-picker>
                                  </v-menu>
                                </v-flex>
                                <v-flex xs12 sm12 md12>
                                  <v-autocomplete
                                    :items="paymentMethods"
                                    v-model="formPayment.payment_method"
                                    label="Payment Method"
                                    single-line
                                    required
                                    item-text="name"
                                    item-value="name"
                                    v-validate="'required'"
                                    data-vv-name="payment method"     
                                    :error-messages="errors.collect('payment method')"  
                                    required
                                  ></v-autocomplete>
                                </v-flex>
                                <v-flex xs12 sm12 md12>
                                  <v-autocomplete
                                    :items="currencies"
                                    v-model="formPayment.currency_id"
                                    label="Currency"
                                    single-line
                                    required
                                    item-text="name"
                                    item-value="id"
                                    v-validate="'required'"
                                    data-vv-name="currency"     
                                    :error-messages="errors.collect('currency')"  
                                    required
                                  ></v-autocomplete>
                                </v-flex>
                                <v-flex xs12 sm12 md12>
                                  <v-text-field v-model="formPayment.amount" label="Amount" required></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm12 md12>
                                  <v-text-field v-model="formPayment.transaction_id" label="Transaction ID" required></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm12 md12>
                                  <v-text-field v-model="formPayment.remark" label="Remark" required></v-text-field>
                                </v-flex>
                            </v-layout>
                          </v-container>
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="blue darken-1" flat @click.native="basic.dialogPayment = false">Close</v-btn>
                          <v-btn type="submit" color="blue darken-1" flat>Save</v-btn>
                        </v-card-actions>
                    </v-card>
                  </v-form>
                </v-dialog>
              </v-tab>

              <!--<v-tab href="#tab-4">
                <v-icon>sync</v-icon> &nbsp; Merchandise Return
              </v-tab>-->

              <!--Tab 1-->
              <v-tab-item id="tab-1">
                <v-layout row>
                  <v-flex xs6>
                    <v-list two-line>
                      <v-list-tile href="javascript:void(0);">
                        <v-list-tile-action>
                          <v-icon color="indigo">local_shipping</v-icon>
                        </v-list-tile-action>
                        <div xs12>
                          <v-autocomplete
                            :items="orderStatus"
                            v-model="formData.order_status_id"
                            label="Order Status"
                            single-line
                            required
                            item-text="name"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="order status"     
                            :error-messages="errors.collect('order status')"  
                            required
                          ></v-autocomplete>
                        </div>
                      </v-list-tile>
                      
                      <v-list-tile href="javascript:void(0);">
                        <v-list-tile-action>
                          <v-icon color="indigo">mail</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                          <v-list-tile-title>{{ data['email'] }}</v-list-tile-title>
                          <v-list-tile-sub-title>Personal</v-list-tile-sub-title>
                        </v-list-tile-content>
                      </v-list-tile>
                      <v-divider inset></v-divider>
                      <v-list-tile href="javascript:void(0);">
                        <v-list-tile-action>
                          <v-icon color="indigo">location_on</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                          <v-list-tile-title>{{ data['payment_address_1'] }}</v-list-tile-title>
                          <v-list-tile-sub-title></v-list-tile-sub-title>
                        </v-list-tile-content>
                        <v-list-tile-content>
                          <v-list-tile-title>{{ data['payment_address_2'] }}</v-list-tile-title>
                          <v-list-tile-sub-title></v-list-tile-sub-title>
                        </v-list-tile-content>
                      </v-list-tile>
                    </v-list>
                  </v-flex>
                </v-layout>
              </v-tab-item><!--#End tab-1-->
              <!--tab 2-->
              <v-tab-item id="tab-2">
                <v-spacer>&nbsp;</v-spacer>
                <v-layout justify-center column class="ma-0">
                  <v-card-text class="pa-0">
                    <template>
                      <v-data-table
                        :headers="headerShipment"
                        :items="shipments"
                        hide-actions
                        class="elevation-0 table-striped"
                      >
                        <template slot="items" slot-scope="props">
                          <td>{{ props.index+1 }}</td>
                          <td class="text-xs-left">{{ props.item.carrier }}</td>
                          <td class="text-xs-left">{{ props.item.weight }}</td>
                          <td class="text-xs-left">{{ props.item.shipping_cost_tax_excl }}</td>
                          <td class="text-xs-left">{{ props.item.shipping_cost_tax_incl }}</td>
                          <td class="text-xs-left">{{ props.item.tracking_number }}</td>
                          <td class="text-xs-left">{{ props.item.expected_delivery_date }}</td>
                          <td class="text-xs-left">{{ props.item.pickup_date }}</td>
                          <td class="text-xs-left">{{ props.item.pickup_time }}</td>
                          <td class="text-xs-left">{{ props.item.origin_pick_up }}</td>
                          <td class="text-xs-left">{{ props.item.destination }}</td>
                          <td class="text-xs-left">{{ props.item.date_added }}</td>
                        </template>
                      </v-data-table>
                    </template>
                    <v-divider></v-divider>
                  </v-card-text>
                </v-layout>
              </v-tab-item><!--#End tab 2-->

              <!--tab 3-->
              <v-tab-item id="tab-3">
                <v-spacer>&nbsp;</v-spacer>
                <v-layout justify-center column class="ma-0">
                  <v-card-text class="pa-0">
                    <template>
                      <v-data-table
                        :headers="headerPayment"
                        :items="order_payments"
                        hide-actions
                        class="elevation-0 table-striped"
                      >
                        <template slot="items" slot-scope="props">
                          <td>{{ props.index+1 }}</td>
                          <td class="text-xs-left">{{ props.item.date_add }}</td>
                          <td class="text-xs-left">{{ props.item.amount }}</td>
                          <td class="text-xs-left">{{ props.item.payment_method }}</td>
                          <td class="text-xs-left">{{ props.item.transaction_id }}</td>
                        </template>
                      </v-data-table>
                    </template>
                    <v-divider></v-divider>
                  </v-card-text>
                </v-layout>
              </v-tab-item><!--#End tab 4-->

            </v-tabs><!--#End tab-->
          </v-card>
        
      </v-flex><!--#End order-->
        <!--product-->
        <v-flex lg9>
          <v-card>
            <v-toolbar card dense color="transparent">
              <v-toolbar-title><h4>Order List</h4></v-toolbar-title>
              <v-spacer></v-spacer>
                <!--<v-tooltip bottom>
                <v-btn icon slot="activator">
                  <v-icon color="text--secondary">add</v-icon>
                </v-btn>
                <v-tooltip-->
                <v-dialog v-model="basic.dialog" persistent max-width="500px">                
                    <v-btn icon slot="activator"><v-icon color="text--secondary">add</v-icon></v-btn>
                    <v-card>
                      <v-card-title>
                        <span class="headline">Product</span>
                      </v-card-title>
                      <v-divider></v-divider>
                      <v-card-text>
                        <v-layout wrap>
                          <v-flex xs12 sm12 md12>
                            <!--<v-text-field label="Choose Store" required></v-text-field>-->
                            <v-autocomplete
                                :items="stores"
                                v-model="formProduct.store"
                                label="Store"
                                single-line
                                required
                                item-text="name"
                                item-value="name"
                                v-validate="'required'"
                                data-vv-name="store"     
                                :error-messages="errors.collect('store')"  
                                required
                              ></v-autocomplete>
                          </v-flex>
                          <v-flex xs12 sm12 md12>
                            <!--<v-text-field label="Product Name" required></v-text-field>-->
                            <v-autocomplete
                                :items="products"
                                v-model="formProduct.productName"
                                label="Products"
                                single-line
                                required
                                item-text="name"
                                item-value="id"
                                v-validate="'required'"
                                data-vv-name="product"     
                                :error-messages="errors.collect('product')"  
                                required
                              ></v-autocomplete>
                          </v-flex>
                          <v-flex xs12 sm12 md12>
                            <v-text-field v-model="formProduct.qty" label="Quantity" required></v-text-field>
                          </v-flex>
                        </v-layout>
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click.native="basic.dialog = false">Close</v-btn>
                        <v-btn color="blue darken-1" flat @click="saveOrderItem();">Save</v-btn>
                      </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-toolbar>
            <v-divider></v-divider>
            <v-card-text class="pa-0">
              <template>
                <v-data-table
                  :headers="headers"
                  :items="items"
                  hide-actions
                  class="elevation-0 table-striped"
                >
                  <template slot="items" slot-scope="props">
                    <td>{{ props.index+1 }}</td>
                    <td class="text-xs-left">{{ props.item.name }}</td>
                    <td class="text-xs-left">{{ props.item.model }}</td>
                    <td class="text-xs-left">{{ props.item.tax }}</td>
                    <td class="text-xs-left">{{ props.item.reward }}</td>
                    <td class="text-xs-left">{{ props.item.quantity }}</td>
                    <td class="text-xs-left">{{ props.item.price }}</td>
                    <td class="text-xs-left">
                      <v-btn @click="btnConfirm(props.item.id)" depressed outline icon fab dark color="red" small>
                        <v-icon>delete</v-icon>
                      </v-btn>
                    </td>
                  </template>
                </v-data-table>
              </template>
              <v-divider></v-divider>
            </v-card-text>
          </v-card>
        </v-flex><!--#End product-->

        <!--v-flex-->
        <v-flex lg3>
          <v-card class="_mt-3">
            <v-list two-line>
              <v-list-tile href="javascript:void(0);">
                <v-list-tile-action>
                  Sub Total : {{ sub_total }}
                </v-list-tile-action>
              </v-list-tile>
              <v-divider></v-divider>
              
              <v-list-tile href="javascript:void(0);">
                <v-list-tile-action>
                  Grand Total : {{ grand_total }}
                </v-list-tile-action>
              </v-list-tile>
              <v-divider></v-divider>

              <v-list-tile href="javascript:void(0);">
                <v-list-tile-action>
                  Shipping : {{ shipping_amount }}
                </v-list-tile-action>
              </v-list-tile>
            </v-list>
          </v-card>
        </v-flex><!--#End v-flex-->

      </v-layout>

    </v-container>
  </div>
</template>

<script>
import {fetchList} from '~/api/catalog/product'
import { createData,editData,updateData, createPaymentOrder } from '~/api/saleOrder/order';
import { fetchCurrency } from '~/api/catalog/currencyRate';
import { fetchOrderStatusList } from '~/api/system/orderStatus';
import { fetchPaymentMethodList } from '~/api/payment/paymentMethod';
import { fetchCarrierList } from '~/api/shipping/carrier';
import { fetchStoreList } from '~/api/system/store';
import { fetchCustomerList } from '~/api/customer/customer';
import { getUser } from '~/api/user';
import items from '~/api/order';
import Message from '~/components/common/Message';
import BreadCrumb from '~/components/common/BreadCrumb';
import VWidget from '~/components/VWidget';
import Flash from '~/services/flash';
export default {
  props:['id'],
  components: {
    BreadCrumb,
    VWidget
  },
  data () {
    return {
      basic: {
        dialog: false,
        dialogShipping: false,
        dialogPayment: false,
      },
      grand_total: 0,
      sub_total: 0,
      shipping_amount: 0,
      stores: [],
      products: [],
      data:{},
      notifyStatus: '',
      message: '',
      orderStatus: [],
      availableDate: null,
      valid: true,
      validShipping: true,
      parent_name:'Orders',
      child_name:'Order Detail',
      routeName:'Sale Orders',
      shippingData: {
        date: 'Date',
        carrier: 'Carrier',
        weight: 'Weight',
        shipping_cost: 'Shipping Cost',
        tracking_number: 'Tracking Number',
      },
      formData: {
        order_status_id: '',
        customer_id: ''
      },
      formPayment: {
        order_id: this.id,
        date: '',
        amount: 0,
        payment_method: '',
        transaction_id: '',
        remark: ''
      },
      formProduct: {
        store: '',
        productName: '',
        qty: 1
      },
      formCarrier: {
        carrier_id: '',
        order_id: '',
        amount: '',
        weight: '',
        shipping_cost_tax_excl: '',
        shipping_cost_tax_incl: '',
        tracking_number: '',
        expected_delivery_date: '',
        pickup_date: '',
        pickup_time: '',
        origin_pick_up: '',
        destination: '',
        date_added: ''
      },
      messages: [
        // {
        //   avatar: 'https://avatars0.githubusercontent.com/u/9064066?v=4&s=460',
        //   name: 'John Leider',
        //   title: 'Welcome to Vuetify.js!',
        //   excerpt: 'Thank you for joining our community...'
        // },
        {
          color: 'red',
          icon: 'people',
          name: 'DHL',
          title: 'Decription'
        },
        {
          color: 'teal',
          icon: 'local_offer',
          name: 'Promos',
          new: 2,
          total: 4,
          title: 'Shop your way',
          exceprt: 'New deals available, Join Today'
        }
        // {
        //   color: 'teal',
        //   icon: 'local_offer',
        //   name: 'Promos',
        //   new: 2,
        //   total: 4,
        //   title: 'Shop your way',
        //   exceprt: 'New deals available, Join Today'
        // }
      ],
      headers: [
        {
          text: '#',
          align: 'left',
          sortable: false,
          value: 'id'
        },
        { text: 'Product', value: 'name' },
        { text: 'Model', value: 'model' },
        { text: 'Tax', value: 'tax' },
        { text: 'Reward', value: 'reward' },
        { text: 'Quantity', value: 'quantity' },
        { text: 'Price', value: 'price' },
        { text: 'Action', value: 'action' },

      ],
      headerShipment: [
        {
          text: '#',
          align: 'left',
          sortable: false,
          value: 'id'
        },
        { text: 'Carrier', value: 'carrier' },
        { text: 'Weight', value: 'weight' },
        { text: 'Shipping Cost Tax Excl', value: 'shipping_cost_tax_excl' },
        { text: 'Shipping Cost Tax Incl', value: 'shipping_cost_tax_incl' },
        { text: 'Tracking Number', value: 'tracking_number' },
        { text: 'Expected Delivery Date', value: 'expected_delivery_date' },
        { text: 'Pickup Date', value: 'pickup_date' },
        { text: 'Pickup Time', value: 'pickup_time' },
        { text: 'Origin Pick Up', value: 'origin_pick_up' },
        { text: 'Destination', value: 'destination' },
        { text: 'Date Added', value: 'date_added' }
      ],
      headerPayment: [
        {
          text: '#',
          align: 'left',
          sortable: false,
          value: 'id'
        },
        { text: 'Date', value: 'date' },
        { text: 'Amount', value: 'amount' },
        { text: 'Payment Method', value: 'payment_method' },
        { text: 'Transaction ID', value: 'transaction_id' }
      ],
      items: [],
      shipments: [],
      order_payments: [],
      paymentMethods: [],
      currencies: [],
      carriers: [],
      customers: [],
      colors: {
        processing: 'blue',
        sent: 'red',
        delivered: 'green'
      },
      folders: [
        { icon: 'folder', iconClass: 'grey lighten-1 white--text', title: 'Photos', subtitle: 'Jan 9, 2014' },
        { icon: 'folder', iconClass: 'grey lighten-1 white--text', title: 'Recipes', subtitle: 'Jan 17, 2014' },
        { icon: 'folder', iconClass: 'grey lighten-1 white--text', title: 'Work', subtitle: 'Jan 28, 2014' }
      ],
      files: [
        { icon: 'assignment', iconClass: 'blue white--text', title: 'Vacation itinerary', subtitle: 'Jan 20, 2014' },
        { icon: 'call_to_action', iconClass: 'amber white--text', title: 'Kitchen remodel', subtitle: 'Jan 10, 2014' }
      ],
      topics: [
        {
          action: 'local_activity',
          title: 'Attractions',
          items: [
            { title: 'List Item' }
          ]
        },
        {
          action: 'restaurant',
          title: 'Dining',
          active: true,
          items: [
            { title: 'Breakfast & brunch' },
            { title: 'New American' },
            { title: 'Sushi' }
          ]
        },
        {
          action: 'school',
          title: 'Education',
          items: [
            { title: 'List Item' }
          ]
        },
        {
          action: 'directions_run',
          title: 'Family',
          items: [
            { title: 'List Item' }
          ]
        },
        {
          action: 'healing',
          title: 'Health',
          items: [
            { title: 'List Item' }
          ]
        },
        {
          action: 'content_cut',
          title: 'Office',
          items: [
            { title: 'List Item' }
          ]
        },
        {
          action: 'local_offer',
          title: 'Promotions',
          items: [
            { title: 'List Item' }
          ]
        }
      ],
      chats: [
        { header: 'Today' },
        { avatar: 'https://randomuser.me/api/portraits/men/1.jpg', title: 'Brunch this weekend?', subtitle: "<span class='text--primary'>Ali Connors</span> &mdash; I'll be in your neighborhood doing errands this weekend. Do you want to hang out?" },
        { divider: true, inset: true },
        { avatar: 'https://randomuser.me/api/portraits/men/2.jpg', title: 'Summer BBQ <span class="grey--text text--lighten-1">4</span>', subtitle: "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend." },
        { divider: true, inset: true },
        { avatar: 'https://randomuser.me/api/portraits/men/3.jpg', title: 'Oui oui', subtitle: "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?" },
        { divider: true, inset: true },
        { avatar: 'https://randomuser.me/api/portraits/men/4.jpg', title: 'Birthday gift', subtitle: "<span class='text--primary'>Trevor Hansen</span> &mdash; Have any ideas about what we should get Heidi for her birthday?" },
        { divider: true, inset: true },
        { avatar: 'https://randomuser.me/api/portraits/men/5.jpg', title: 'Recipe to try', subtitle: "<span class='text--primary'>Britta Holt</span> &mdash; We should eat this: Grate, Squash, Corn, and tomatillo Tacos." }
      ]
    };
  },
  computed: {
    randomColor () {
      let item = Math.floor(Math.random() * this.colors.length);
      return this.colors[item];
    },
    computeCardLayout () {
      return (this.mini) ? 'row' : 'column';
    },
    computeTextAlgin () {
      return (this.mini) ? 'text-sm-right' : 'text-sm-center';
    },
    computeAvatarSize () {
      return (this.mini) ? '48' : '96';
    },
    showAvatar () {
      return this.avatar !== null && this.avatar.src;
    },

    showBottomNav () {
      return (this.mini === false && this.bottomNav); 
    },

    showTopNav () {
      return (this.mini === false && this.topNav); 
    },
    users () {
      return getUser(3);
    },
    allUsers () {
      return getUser();
    }
  },
  created() {
    if(this.id){
      Flash.setLoading(true)
      this.getData();
    }
    this.getOrderStatus();
    this.getProduct();
    this.getStore();
    this.fetchCurrency();
    this.fetchPaymentMethod();
    this.fetchCarrier();
    this.fetchCustomer();
  },
  methods: {
    addShipment(){

      this.carriers.push({
        carrier_id: this.formCarrier.carrier_id,
        amount: this.formCarrier.amount,
        weight: this.formCarrier.weight,
        shipping_cost_tax_excl: this.formCarrier.shipping_cost_tax_excl,
        shipping_cost_tax_incl: this.formCarrier.shipping_cost_tax_incl,
        tracking_number: this.formCarrier.tracking_number,
        expected_delivery_date: this.formCarrier.expected_delivery_date,
        pickup_date: this.formCarrier.pickup_date,
        pickup_time: this.formCarrier.pickup_time,
        origin_pick_up: this.formCarrier.origin_pick_up,
        destination: this.formCarrier.destination
      });
      
      //   createPaymentOrder(this.formPayment).then(response => {
      //     if(response.success == true){
      //       this.notifyStatus = 'success';
      //       this.message = "Success fully";
      //       this.formPayment = [];
      //       this.basic.dialogPayment = false;
      //     }else{
      //       this.notifyStatus = 'error';
      //       this.message = response.message;
      //     }
      //   }).catch(e => {
      //       this.notifyStatus = 'error'
      //       this.message = 'Error while trying to create data!'
      //   })
    },
    onSubmitPayment(){
      this.$validator.validateAll().then((result) => {
        if(!result){
          this.notifyStatus = 'error';
          this.message = 'All fields are required!';
          return false;
        }
              
        createPaymentOrder(this.formPayment).then(response => {
          if(response.success == true){
            this.notifyStatus = 'success';
            this.message = "Success fully";
            this.formPayment = [];
            this.basic.dialogPayment = false;
          }else{
            this.notifyStatus = 'error';
            this.message = response.message;
          }
        }).catch(e => {
            this.notifyStatus = 'error'
            this.message = 'Error while trying to create data!'
        })
      });
    },
    savePayment(){
      alert('save payment');
    },
    saveOrderItem(){
      this.$validator.validateAll().then((result) => {
        if(!result){
          this.notifyStatus = 'error';
          this.message = 'All fields are required!';
          return false;
        }
      });
      const productOrder = {
        name: this.formProduct.productName,
        storeId: this.formProduct.store
      }
      this.items.push({
        name: this.formProduct.productName,
        model:'model',
        tax:'tax',
        reward:'reward',
        quantity:'quantity',
        price:'price',
      });
      console.log('save order data', productOrder);
    },
    fetchCustomer(){
      fetchCustomerList().then(response => {
        // this.datatable = response
        for(let x=0 ; x <= response['data'].length-1 ; x++){
          let data = {'id':response['data'][x]['customer_id'],'name':response['data'][x]['lastname'] + response['data'][x]['firstname']};
          this.customers.push(data);
        }
      })
    },
    getStore(){
      fetchStoreList().then(response => {
        // this.datatable = response
        for(let x=0 ; x <= response['data'].length-1 ; x++){
          let data = {'store_id':response['data'][x]['store_id'],'name':response['data'][x]['name']};
          this.stores.push(data);
        }
      })
    },
    fetchCurrency() {
      fetchCurrency().then(response => {
        for(let x=0 ; x <= response['data'].length-1 ; x++){
          let data = {'id':response['data'][x]['currency_id'],'name':response['data'][x]['code']};
          this.currencies.push(data);
        }
      })
    },
    fetchCarrier() {
      fetchCarrierList().then(response => {
        for(let x=0 ; x <= response['data'].length-1 ; x++){
          let data = {'id':response['data'][x]['carrier_id'],'name':response['data'][x]['name']};
          this.carriers.push(data);
        }
      })
    },
    fetchPaymentMethod() {
      fetchPaymentMethodList().then(response => {
        for(let x=0 ; x <= response['data'].length-1 ; x++){
          let data = {'id':response['data'][x]['payment_method_id'],'name':response['data'][x]['name']};
          this.paymentMethods.push(data);
        }
      })
    },
    getOrderStatus(){
      fetchOrderStatusList().then(response => {
        // this.datatable = response
        for(let x=0 ; x <= response['data'].length-1 ; x++){
          let data = {'id':response['data'][x]['order_status_id'],'name':response['data'][x]['name']};
          this.orderStatus.push(data);
        }
      })
    },
    getProduct() {
      fetchList().then(response => {
        for(let x=0 ; x <= response['data'].length-1 ; x++){
          let data = {'id':response['data'][x]['id'],'name':response['data'][x]['product_name']};
          this.products.push(data);
        }
      })
    },
    getData() {
      editData(this.id).then(response => {
        // fetch all form data
        this.data = response['data'][0];
        console.log('customer data', this.data);
        this.formData.order_status_id = this.data.order_status_id;
        this.formData.customer_id = this.data.customer_id;
        this.items = response['data']['products'];
        this.shipments = response['data']['shipment'];
        this.order_payments = response['data']['order_payment'];
        Flash.setLoading(false)
      })
    },
    getColorByStatus (status) {
      return this.colors[status];
    },
    handleClick (e) {
      return false;
    }
  }
};
</script>