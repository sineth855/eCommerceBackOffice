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
                  <v-list-tile href="">
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
                  <v-list-tile href="#">
                    <v-list-tile-action>
                      <v-icon color="indigo">mail</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                      <v-list-tile-title>{{ data['email'] }}</v-list-tile-title>
                      <v-list-tile-sub-title>Personal</v-list-tile-sub-title>
                    </v-list-tile-content>
                  </v-list-tile>
                  <v-divider inset></v-divider>
                  <v-list-tile href="#">
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
              </v-card>
            </v-flex><!--#End v-flex-->

          </v-layout>
        </v-flex>
        
        <!--Order-->
        <v-flex lg8>
          <v-card>
            <!--tab-->
            <v-tabs text-and-icons>
              
              <v-tab href="#tab-1">
                <v-icon>payment</v-icon> &nbsp; Order
              </v-tab>

              <v-tab href="#tab-2">
                <v-icon>local_shipping</v-icon> &nbsp; Shipping
              </v-tab>

              <v-tab href="#tab-3">
                <v-icon>money</v-icon> &nbsp; Payment
                <v-tooltip bottom>
                  <v-btn icon slot="activator">
                    <v-icon color="text--secondary">add</v-icon>
                  </v-btn>
                  <span>Add more payment</span>
                </v-tooltip>
              </v-tab>

              <!--<v-tab href="#tab-4">
                <v-icon>sync</v-icon> &nbsp; Merchandise Return
              </v-tab>-->

              <!--Tab 1-->
              <v-tab-item id="tab-1">
                <v-layout row>
                  <v-flex xs6>
                    <v-list two-line>
                      <v-list-tile href="">
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
                      <v-divider inset></v-divider>
                      <v-list-tile href="#">
                        <v-list-tile-action>
                          <v-icon color="indigo">mail</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                          <v-list-tile-title>{{ data['email'] }}</v-list-tile-title>
                          <v-list-tile-sub-title>Personal</v-list-tile-sub-title>
                        </v-list-tile-content>
                      </v-list-tile>
                      <v-divider inset></v-divider>
                      <v-list-tile href="#">
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
              <v-tooltip bottom>
                <v-btn icon slot="activator">
                  <v-icon color="text--secondary">add</v-icon>
                </v-btn>
                <span>Add More Products</span>
              </v-tooltip> 
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
                    <td class="text-xs-left"><v-chip label small :color="getColorByStatus(props.item.order_status_id)" text-color="white" >{{ props.item.order_status_id }}</v-chip></td>
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
              <v-list-tile href="">
                <v-list-tile-action>
                  Total : {{ '120' }}
                </v-list-tile-action>
              </v-list-tile>
              <v-divider></v-divider>
              
              <v-list-tile href="">
                <v-list-tile-action>
                  Sub Total : {{ '120' }}
                </v-list-tile-action>
              </v-list-tile>
              <v-divider></v-divider>

              <v-list-tile href="">
                <v-list-tile-action>
                  Shipping : {{ '120' }}
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
import {createData,editData,updateData} from '~/api/saleOrder/order'
import { fetchOrderStatusList } from '~/api/system/orderStatus';
import { getUser } from '~/api/user';
import items from '~/api/order';
import BreadCrumb from '~/components/common/BreadCrumb'
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
      data:{},
      orderStatus: [],
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
        order_status_id: ''
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
        { text: 'Status', value: 'status' },

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
        { text: 'Payment Method', value: 'payment_method' },
        { text: 'Transaction ID', value: 'transaction_id' },
        { text: 'Amount', value: 'amount' },
        { text: 'Invoice', value: 'invoice' }
      ],
      items: [],
      shipments: [],
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
    this.getOrderStatus();
    if(this.id){
      Flash.setLoading(true)
      this.getData();
    }
  },
  methods: {
    getOrderStatus(){
      fetchOrderStatusList().then(response => {
        // this.datatable = response
        for(let x=0 ; x <= response['data'].length-1 ; x++){
          let data = {'id':response['data'][x]['order_status_id'],'name':response['data'][x]['name']};
          this.orderStatus.push(data);
        }
      })
    },
    getData() {
      editData(this.id).then(response => {
        // fetch all form data
        this.data = response['data'];
        this.items = response['data']['products'];
        this.shipments = response['data']['shipment'];
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