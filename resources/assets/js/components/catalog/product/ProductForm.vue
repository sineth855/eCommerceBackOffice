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
                      <v-icon>settings</v-icon> &nbsp; General
                    </v-tab>

                    <v-tab href="#tab-2">
                      <v-icon>dashboard</v-icon> &nbsp; Data
                    </v-tab>

                    <v-tab href="#tab-3">
                      <v-icon>image</v-icon> &nbsp; Image
                    </v-tab>

                    <v-tab href="#tab-4">
                      <v-icon Small>import_export</v-icon> &nbsp; Attribute
                    </v-tab>

                    <v-tab href="#tab-5">
                      <v-icon>local_shipping</v-icon> &nbsp; Shipping
                    </v-tab>

                    <!--<v-tab href="#tab-6">
                      <v-icon>archive</v-icon> &nbsp; Option
                    </v-tab>-->

                    <v-tab href="#tab-7">
                      <v-icon>av_timer</v-icon> &nbsp; Discount
                    </v-tab>

                    <v-tab href="#tab-8">
                      <v-icon>favorite</v-icon> &nbsp; Special
                    </v-tab>

                    <!--Tab 1-->
                    <v-tab-item id="tab-1">
                      <v-spacer>&nbsp;</v-spacer>
                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Product Name *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Product Name"
                            name="name"
                            placeholder="Product Name"
                            v-model="formData.name"
                            v-validate="'required'"
                            data-vv-name="product name"     
                            :error-messages="errors.collect('product name')"  
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
                      <v-spacer>&nbsp;</v-spacer>
                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Model *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Model"
                            name="name"
                            autocomplete = "off"
                            placeholder="Model"
                            v-model="formData.model"
                            v-validate="'required'"
                            data-vv-name="model"     
                            :error-messages="errors.collect('model')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>SKU</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="SKU"
                            name="name"
                            autocomplete = "off"
                            placeholder="SKU"
                            v-model="formData.sku"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Manufacturers *</v-subheader>
                        </v-flex>
                          <v-flex xs6>
                            <v-autocomplete
                              :items="manufacturer"
                              v-model="formData.manufacturer_id"
                              label="Manufacturer"
                              single-line
                              required
                              item-text="name"
                              item-value="id"
                              v-validate="'required'"
                              data-vv-name="manufacturer"     
                              :error-messages="errors.collect('manufacturer')"  
                              required
                            ></v-autocomplete>
                            <v-flex xs6>
                        </v-flex>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Category *</v-subheader>
                          </v-flex>
                            <v-flex xs6>
                              <v-combobox
                                :items="category"
                                v-model="formData.category"
                                tags
                                chips
                                multiple=""
                                label="Category"
                                class="input-group--focused"
                                item-text="name"
                                v-validate="'required'"
                                data-vv-name="category"     
                                :error-messages="errors.collect('category')"  
                                required
                              ></v-combobox>
                            <v-flex xs6>
                          </v-flex>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Filter *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-combobox
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
                          ></v-combobox>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Store *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-combobox
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
                          ></v-combobox>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Location</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Location"
                            name="name"
                            autocomplete = "off"
                            placeholder="Location"
                            v-model="formData.location"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Price *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Price"
                            name="name"
                            autocomplete = "off"
                            placeholder="Price"
                            v-model="formData.price"
                            v-validate="'required'"
                            data-vv-name="price"     
                            :error-messages="errors.collect('price')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Tax Class *</v-subheader>
                        </v-flex>
                          <v-flex xs6>
                            <v-autocomplete
                              :items="taxClass"
                              v-model="formData.tax_class_id"
                              label="Tax Class"
                              single-line
                              required
                              item-text="name"
                              item-value="id"
                              v-validate="'required'"
                              data-vv-name="tax class"     
                              :error-messages="errors.collect('tax class')"  
                              required
                            ></v-autocomplete>
                            <v-flex xs6>
                        </v-flex>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Quantity *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Quantity"
                            name="name"
                            type="number"
                            autocomplete = "off"
                            placeholder="Tax Class"
                            v-model="formData.quantity"
                            v-validate="'required'"
                            data-vv-name="quantity"     
                            :error-messages="errors.collect('quantity')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Minimum Quantity *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Minimum Quantity"
                            type="number"
                            name="name"
                            autocomplete = "off"
                            placeholder="Minimum Quantity"
                            v-model="formData.minimum"
                            v-validate="'required'"
                            data-vv-name="minimum order"     
                            :error-messages="errors.collect('minimum order')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Subtract Stock *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-radio-group v-model="formData.subtract" row>
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
                          <v-subheader>Out Of Stock *</v-subheader>
                        </v-flex>
                          <v-flex xs6>
                            <v-autocomplete
                              :items="stockStatus"
                              v-model="formData.stock_status_id"
                              label="Out Of Stock"
                              single-line
                              required
                              item-text="name"
                              item-value="id"
                              v-validate="'required'"
                              data-vv-name="out of stock"     
                              :error-messages="errors.collect('out of stock')"  
                              required
                            ></v-autocomplete>
                            <v-flex xs6>
                        </v-flex>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Required Shipping *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-radio-group v-model="formData.shipping" row>
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

                      <v-layout>
                        <v-flex xs3>
                          <v-subheader>Available Date *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
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
                                label="Start Date"
                                v-model="formData.date_available"
                                append-icon="event"
                                readonly
                                v-validate="'required'"
                                data-vv-name="date available"     
                                :error-messages="errors.collect('date available')"  
                                required
                              ></v-text-field>
                              <v-date-picker v-model="formData.date_available" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn flat color="primary" @click="availableDate = false">Cancel</v-btn>
                                <v-btn flat color="primary" @click="$refs.statAvailableDate.save(formData.date_available)">OK</v-btn>
                              </v-date-picker>
                            </v-menu>
                        </v-flex>
                        
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Related Product</v-subheader>
                        </v-flex>
                          <v-flex xs6>
                            <v-combobox
                              :items="product"
                              v-model="formData.related_product"
                              tags
                              chips
                              multiple=""
                              label="Product"
                              class="input-group--focused"
                              item-text="name"
                            ></v-combobox>
                            <v-flex xs6>
                        </v-flex>
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

                    <!--tab 3-->
                    <v-tab-item id="tab-3">
                      <v-spacer>&nbsp;</v-spacer>
                      <v-layout row>
                        <v-flex xs2>
                          <div class="box">
                            <input name="image" type="file" id="fileInput"  style="display:none" ref="fileInput" accept="image/*" @change="showPreviewMainImage($event)"/>
                            <label for="fileInput">
                              <v-card>
                                <v-badge color="red" overlap style="font-size:10px;position:absolute;left:0;">
                                  <v-btn small @click="clearMainImage">
                                    Remove
                                  </v-btn>
                                </v-badge>
                                <img width="100%" class="image" :src="imagePreview"/>
                                <input type="hidden" v-model="formData.image"/>
                              </v-card>
                            </label>
                            <!--<input type="file" accept="image/*" name="fileupload" v-on:change="showPreviewImage($event)" id="file-5" class="inputfile inputfile-4" data-multiple-caption="{count} files selected" />
                            <label for="file-5"><figure><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure> <span>Choose a file&hellip;</span></label>
                            <span v-if="imagePreview.length > 0">
                              <img width="100px" :src="imagePreview"/><br/>
                            </span>-->
                          </div>
                        </v-flex>
                      </v-layout>
                      
                      <v-layout row>
                        <v-flex sm12 lg12>
                          <v-divider></v-divider>
                        </v-flex>
                      </v-layout>

                      <!--<v-layout row for="item in gallery; let i = index">-->
                      <div v-for="(data, key) in gallery">
                        <v-layout row>
                          <v-flex sm3 lg2>
                            <input type="file" style="display:none" v-bind:id="'fileInput' + key" v-bind:ref="'fileInput' + key" accept="image/*" @change="showGallary($event,key,data.sort_order)"/>
                            <label v-bind:for="'fileInput' + key">  
                              <v-card>
                                <v-badge color="red" overlap style="font-size:10px;position:absolute;left:0;">
                                  <v-btn small @click="clearGallaryImage(key)">
                                    Remove
                                  </v-btn>
                                </v-badge>
                                <img width="100%" :class="'imgGallary' + key" :src="data.image?data.image:galleryPreview">
                                <v-text-field
                                    label="Text"
                                    style="display:none"
                                    :ref="'g_imageGallary'+ key"
                                    v-model="data.image"
                                    v-bind:value="data['image']"
                                    name="imageGallary[]"
                                    :key="data.image"
                                    :class="'g_imageGallary'+ key"
                                    autocomplete = "off"
                                  ></v-text-field>
                                  <!--<input type="text" v-bind:value="data['image']" autocomplete = "off" name="imageGallary[]" :ref="'g_imageGallary'+ key" :class="'g_imageGallary'+ key"/>-->
                              </v-card>
                            </label><!--</v-layout>-->
                          </v-flex>

                          <v-flex sm3 lg3>
                            <v-text-field
                              label="Sort Order"
                              name="name"
                              :ref="'g_sort_order'+ key"
                              v-model="data.sort_order"
                              type="number"
                              autocomplete = "off"
                              placeholder="Sort Order"
                            ></v-text-field>
                          </v-flex>

                          <v-flex sm3 lg3>
                            <v-btn small @click="removeGallary(key)" color="error" dark>Remove</v-btn>
                          </v-flex>
                        </v-layout>
                      </div>

                      <v-layout row>
                        <v-flex sm2 lg2>
                          &nbsp;
                        </v-flex>

                        <v-flex sm3 lg3>
                          &nbsp;
                        </v-flex>

                        <v-flex sm3 lg3>
                          <v-btn small color="primary" @click="addGallary()" dark>Add Gallary</v-btn>
                        </v-flex>
                      </v-layout>
                    </v-tab-item><!--#End tab 3-->
                  
                    <!--tab-4-->
                    <v-tab-item id="tab-4">
                      <v-spacer>&nbsp;</v-spacer>
                      <div v-for="(data, key) in attribute" :key="key">
                        <v-layout row>
                          <v-flex sm4 lg4>
                            <v-autocomplete
                              :items="attributeData"
                              v-model="data.attribute_id"
                              v-bind:value="data['attribute_id']"
                              name="attribute_id[]"
                              :ref="'attribute'+ key"
                              v-bind:class="'attribute'+ key"
                              label="Attribute"
                              single-line
                              required
                              :key="key"
                              item-text="name"
                              item-value="id"
                              v-validate="'required'"
                              data-vv-name="attribute"     
                              :error-messages="errors.collect('attribute')"  
                              required
                            ></v-autocomplete>
                          </v-flex>

                          <v-flex sm4 lg4>
                            <v-text-field
                              label="Text"
                              :ref="'text'+ key"
                              v-model="data.text"
                              v-bind:value="data['text']"
                              name="text[]"
                              v-bind:class="'text'+ key"
                              autocomplete = "off"
                              placeholder="Text"
                              v-validate="'required'"
                              data-vv-name="text"     
                              :error-messages="errors.collect('text')"  
                              required
                            ></v-text-field>
                          </v-flex>

                          <v-flex sm3 lg3>
                            <v-btn small color="error" @click="removeAttribute(key)" dark>Remove</v-btn>
                          </v-flex>
                        </v-layout>
                      </div>

                      <v-layout row>
                        <v-flex sm4 lg4>
                          &nbsp;
                        </v-flex>

                        <v-flex sm4 lg4>
                          &nbsp;
                        </v-flex>

                        <v-flex sm3 lg3>
                          <v-btn small color="primary" @click="addAttribute()" dark>Add Attribute</v-btn>
                        </v-flex>
                      </v-layout>
                    </v-tab-item>

                    <!--tab-5-->
                    <v-tab-item id="tab-5">
                     <v-spacer>&nbsp;</v-spacer>
                     <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Length</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Length"
                            name="name"
                            autocomplete = "off"
                            placeholder="Length"
                            v-model="formData.length"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Width</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Width"
                            name="name"
                            autocomplete = "off"
                            placeholder="Width"
                            v-model="formData.width"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Height</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Height"
                            name="name"
                            autocomplete = "off"
                            placeholder="Height"
                            v-model="formData.height"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Length Class</v-subheader>
                        </v-flex>
                          <v-flex xs6>
                            <v-autocomplete
                              :items="lengthClass"
                              v-model="formData.length_class_id"
                              label="Length Class"
                              single-line
                              required
                              item-text="name"
                              item-value="id"
                            ></v-autocomplete>
                            <v-flex xs6>
                        </v-flex>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Weight</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Weight"
                            name="name"
                            autocomplete = "off"
                            placeholder="Weight"
                            v-model="formData.weight"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Weight Class</v-subheader>
                        </v-flex>
                          <v-flex xs6>
                            <v-autocomplete
                              :items="weightClass"
                              v-model="formData.weight_class_id"
                              label="Weight Class"
                              single-line
                              required
                              item-text="name"
                              item-value="id"
                            ></v-autocomplete>
                            <v-flex xs6>
                        </v-flex>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Carriers</v-subheader>
                          </v-flex>
                            <v-flex xs6>
                              <v-combobox
                                :items="carrier"
                                v-model="formData.carrier"
                                tags
                                chips
                                multiple=""
                                label="Carriers"
                                class="input-group--focused"
                                item-text="name"
                              ></v-combobox multiple>
                            <v-flex xs6>
                          </v-flex>
                        </v-flex>
                      </v-layout>

                    </v-tab-item>

                    <!--tab-6-->
                    <v-tab-item id="tab-6">
                    </v-tab-item>

                    <!--tab-7-->
                    <v-tab-item id="tab-7">
                      <v-spacer>&nbsp;</v-spacer>
                      <div v-for="(data, key) in discount" :key="key">
                        <v-layout row>
                          <v-flex xs2>
                            <v-select
                              :ref="'d_customer_group_id'+ key"
                              :items="customerGroup"
                              v-model="data.customer_group_id"
                              label="Customer Group"
                              auto
                              required
                              v-bind:value="data['customer_group_id']"
                              name="d_customer_group_id[]"
                              v-bind:class="'d_customer_group_id'+ key"
                              item-text="name"
                              item-value="id"
                              v-validate="'required'"
                              data-vv-name="customer group"     
                              :error-messages="errors.collect('customer group')"  
                            ></v-select>
                          </v-flex>

                          <v-flex sm1 lg1>
                            <v-text-field
                              :ref="'d_quantity'+ key"
                              label="Quantity"
                              name="d_quantity[]"
                              v-bind:class="'d_quantity'+ key"
                              type="number"
                              autocomplete = "off"
                              placeholder="Quantity"
                              v-model="data.quantity"
                            ></v-text-field>
                          </v-flex>

                          <v-flex sm1 lg1>
                            <v-text-field
                              :ref="'d_priority'+ key"
                              label="Priority"
                              name="d_priority[]"
                              v-bind:class="'d_priority'+ key"
                              type="number"
                              autocomplete = "off"
                              placeholder="Priority"
                              v-model="data.priority"
                            ></v-text-field>
                          </v-flex>

                          <v-flex sm2 lg2>
                            <v-text-field
                              :ref="'d_price'+ key"
                              label="Price"
                              name="d_price[]"
                              v-bind:class="'d_price'+ key"
                              type="number"
                              autocomplete = "off"
                              placeholder="Price"
                              v-model="data.price"
                            ></v-text-field>
                          </v-flex>

                          <v-flex sm1 lg2>
                              <v-text-field
                                :ref="'d_start_date'+ key"
                                slot="activator"
                                :key="key"
                                name="d_start_date[]"
                                v-bind:class="'d_start_date'+ key"
                                label="Start Date"
                                type="date"
                                v-model="data.date_start"
                              ></v-text-field>
                          </v-flex>
                          
                          <v-flex sm1 lg2>
                            <v-text-field
                              :ref="'d_end_date'+ key"
                              slot="activator"
                              :key="key"
                              name="d_end_date[]"
                              v-bind:class="'d_end_date'+ key"
                              label="End Date"
                              type="date"
                              v-model="data.date_end"
                            ></v-text-field>
                          </v-flex>

                          <v-flex sm1 lg2>
                            <v-btn small color="error" @click="removeDiscount(key)" dark>Remove</v-btn>
                          </v-flex>
                        </v-layout>
                      </div>

                      <v-layout row>
                        <v-flex sm2 lg2>
                          &nbsp;
                        </v-flex>

                        <v-flex sm3 lg3>
                          &nbsp;
                        </v-flex>

                        <v-flex sm2 lg2>
                          &nbsp;
                        </v-flex>

                        <v-flex sm3 lg3>
                          &nbsp;
                        </v-flex>

                        <v-flex sm2 lg2>
                          &nbsp;
                        </v-flex>

                        <v-flex sm3 lg3>
                          &nbsp;
                        </v-flex>

                        <v-flex sm3 lg3>
                          <v-btn small color="primary" @click="addDiscount()" dark>Add Discount</v-btn>
                        </v-flex>
                      </v-layout>
                    </v-tab-item>

                    <!--tab-8-->
                    <v-tab-item id="tab-8">
                      <v-spacer>&nbsp;</v-spacer>
                      <v-layout row v-for="(data, key) in special" :key="key">
             
                        <v-flex xs2>
                          <v-select
                            :ref="'s_customer_group_id'+ key"
                            :items="customerGroup"
                            v-model="data.customer_group_id"
                            label="Customer Group"
                            auto
                            name="s_customer_group_id[]"
                            v-bind:class="'s_customer_group_id'+ key"
                            required
                            item-text="name"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="customer group"     
                            :error-messages="errors.collect('customer group')"  
                          ></v-select>
                        </v-flex>

                        <v-flex sm2 lg2>
                          <v-text-field
                            :ref="'s_priority'+ key"
                            label="Priority"
                            name="s_priority[]"
                            v-bind:class="'s_priority'+ key"
                            type="number"
                            autocomplete = "off"
                            placeholder="Priority"
                            v-model="data.priority"
                          ></v-text-field>
                        </v-flex>

                        <v-flex sm2 lg2>
                          <v-text-field
                            :ref="'s_price'+ key"
                            label="Price"
                            name="s_price[]"
                            v-bind:class="'s_price'+ key"
                            type="number"
                            autocomplete = "off"
                            placeholder="Price"
                            v-model="data.price"
                          ></v-text-field>
                        </v-flex>

                        <v-flex sm1 lg2>
                            <v-text-field
                              :ref="'s_start_date'+ key"
                              slot="activator"
                              :key="key"
                              name="s_start_date[]"
                              v-bind:class="'s_start_date'+ key"
                              label="Start Date"
                              type="date"
                              v-model="data.date_start"
                            ></v-text-field>
                        </v-flex>
                        
                        <v-flex sm1 lg2>
                          <v-text-field
                            :ref="'s_end_date'+ key"
                            slot="activator"
                            :key="key"
                            name="s_end_date[]"
                            v-bind:class="'s_end_date'+ key"
                            label="End Date"
                            type="date"
                            v-model="data.date_end"
                          ></v-text-field>
                        </v-flex>

                        <v-flex sm1 lg1>
                          <v-btn small color="error" @click="removeSpecial(key)" dark>Remove</v-btn>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex sm2 lg2>
                          &nbsp;
                        </v-flex>

                        <v-flex sm2 lg2>
                          &nbsp;
                        </v-flex>

                        <v-flex sm2 lg2>
                          &nbsp;
                        </v-flex>

                        <v-flex sm2 lg2>
                          &nbsp;
                        </v-flex>

                        <v-flex sm2 lg2>
                          &nbsp;
                        </v-flex>

                        <v-flex sm2 lg2>
                          <v-btn small color="primary" @click="addSpecial()" dark>Add Special</v-btn>
                        </v-flex>
                      </v-layout>
                    </v-tab-item>

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
  input#fileInputGallary{
    position: absolute;
    z-index: 99;
    height: 100px;
  }
</style>
<script>
  import * as $ from 'jquery';

  import {fetchProductList, createData, editData, updateData} from '~/api/catalog/product'
  import {fetchCustomerGroupList} from '~/api/customer/customerGroup'
  import {fetchStockStatusList} from '~/api/catalog/stockStatus'
  import {fetchTaxClassList} from '~/api/system/taxClass'
  import {fetchWeightClassList} from '~/api/system/weightClass'
  import {fetchLengthClassList} from '~/api/system/lengthClass'
  import {fetchCategoryList} from '~/api/catalog/category'
  import {fetchFilterList} from '~/api/catalog/filter'
  import {fetchCarrierList} from '~/api/shipping/carrier'
  import {fetchAttributeList} from '~/api/catalog/attribute'
  import {fetchManufacturerList} from '~/api/catalog/manufacturer'
  import {fetchStoreList} from '~/api/system/store'
  import {uploadFile} from '~/services/fileUpload'
  import {globalUrl, elastickUrl} from '~/config/config'
  import {post} from '~/services/elasticSearch'
  import Message from '~/components/common/Message'
  import BreadCrumb from '~/components/common/BreadCrumb'
  import VWidget from '~/components/VWidget';
  import Flash from '~/services/flash';
  import axios from 'axios';
  import Vue from 'vue'
  const es_host = 'http://35.185.191.11';
  const es_port = 9200;
  const es = require('elasticsearch');
  const client = new es.Client({
      host: '35.185.191.11:9200',
      log: 'trace',
  });
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
        parent_name:'Product',
        child_name:'Product Form',
        routeName:'Product',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        filters: [],
        stores: [],
        category: [],
        manufacturer: [],
        customerGroup: [],
        product: [],
        carrier: [],
        taxClass: [],
        weightClass: [],
        lengthClass: [],
        stockStatus: [],
        availableDateMenu: false,
        availableDate: null,
        gallery: [],
        key: {},
        option: [],
        discount: [],
        special: [],
        attribute: [],
        attributeData: [],
        attributeArr: [],
        discountArr: [],
        galleryArr: [],
        specialArr: [],
        newAttribute: {},
        imagePreview: './img/NoPicture.png',
        galleryPreview: './img/NoPicture.png',
        formData: {
          name: '',
          description: '',
          meta_keyword: '',
          meta_title: '',
          meta_description: '',
          model: '',
          sku: '',
          location: '',
          price: '',
          tax_class_id: 0,
          quantity: 1,
          minimum: 1,
          subtract: 1,
          stock_status_id: '',
          shipping: 1,
          date_available: '',
          manufacturer_id: '',
          category: [],
          filter: [],
          store: [],
          related_product: [],
          sort_order: 1,
          status: 1,
          image: this.imagePreview,
          gallery: [],
          galleryAlt: [],
          attribute: [],
          length: '',
          width: '',
          length_class_id: '',
          weight: '',
          weight_class_id: '',
          carrier: '',
          option: '',
          discount: [],
          special: []
        },
        attributeGroup: [],
      };
    },
    computed: {
    }, 
    created() {
      this.getCustomerGroup();
      if(this.id){
        Flash.setLoading(true)
        this.getData();
      }
      this.getAttribute();
      this.getCarrier();
      this.getCategory();
      this.getStore();
      this.getFilter();
      this.getManufacturer();
      this.getProduct();
      this.getTaxClass();
      this.getWeightClass();
      this.getLengthClass();
      this.getStockStatus();
    },
    methods: {
      initInsertElastic(data){
        console.log("data-log", data);
				let params = {
					"id": "" + data['product_id'] + "",
					"name": "" + data['data']['name'] + "",
					"price": "" + data['data']['price'] + "",
					"status": 1,
					"description": "" + data['data']['description'] + "",
					"isCrawler": false,
					"imageUrl": "" + data['data']['image'] + "",
					"crawlPrice": "0",
					"crawlpriceSpecial": "0",
					"crawldiscountRate": "0",
					"sourceWebsite": "",
					"productLink": "" + data['product_link'] + "",
					"categories": {
						"cat_id": "1",
						"cat_name": "" + data['data']['category'][0]['name'] + "",
						"cat_alias": "" + data['data']['category'][0]['name'] + ""
					},
					"brand": {
						"brandname": "" + data['manufacturer']['name'] + "",
						"image": "",
						"brand_id": "" + data['manufacturer']['manufacturer_id'] + ""
					},
					"store": {
						"store_id":data['data']['store'][0]['store_id'],
						"storename": "" + data['data']['store'][0]['name'] + "",
						"image": "" + data['data']['store'][0]['url'] + ""
					}
				}
        axios.put(''+es_host+':'+es_port+'/store/product/' + data['product_id'] + '', params).then(response => {
				},{headers: {'Content-Type': 'application/json','Accept': 'application/json','Access-Control-Allow-Origin': '*','Access-Control-Allow-Headers': 'Origin, Accept, Content-Type, Authorization, Access-Control-Allow-Origin'}}, response => {
				})
			},
      clearMainImage(){
        this.imagePreview = './img/NoPicture.png';
        this.formData.image = '';
        this.$refs.fileInput = './img/NoPicture.png';
      },
      clearGallaryImage(key){
        this.galleryPreview = './img/NoPicture.png';
        // this.formData.image = '';
        // $('.g_imageGallary'+key).attr('src', this.galleryPreview);
        Vue.set(this.gallery, key, {image: this.galleryPreview})
        // this.$refs.fileInputGallary = './img/NoPicture.png';
      },
      onPickFile(key){
        alert(key);
      },
      // discount
      addDiscount() {
        this.discount.push({});
        this.newAttribute = {};
      },
      removeDiscount(key) {
        this.discount.splice(key, 1);
      },
      // attribute
      addAttribute() {
        this.attribute.push({});
        this.newAttribute = {};
      },
      removeAttribute(key) {
        this.attribute.splice(key, 1);
      },
      // special
      addSpecial() {
        this.special.push({});
        this.newAttribute = {};
      },
      removeSpecial(key) {
        this.special.splice(key, 1);
      },
      // option
      addOption() {
        this.option.push({});
        this.newAttribute = {};
      },
      removeOption(key) {
        this.gallery.splice(key, 1);
      },
      // gallery
      addGallary() {
        this.gallery.push({});
        this.newAttribute = {};
      },
      removeGallary(key) {
        this.gallery.splice(key, 1);
      },
      // Upload Image 
      showPreviewMainImage(event) {
        
        //  event.preventDefault();
        const form = event.target;
        const file = event.target.files[0];
        const fd = new FormData();
        fd.append('image', file);
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
                // this.imagePreview = e.target.result;
                // upload file
                $('.image').attr('src', e.target.result);
                uploadFile(fd).then(response => {
                  if(response.success == true){
                    // create data
                    this.formData.image = response.data.image_url
                  }else{
                    alert("Error while trying to upload file!")
                  }
                }).catch(e => {
                    alert("Error while trying to upload file!")
                    // this.errors.push(e)
                });    

            }
            // Start the reader job - read file as a data url (base64 format)
            reader.readAsDataURL(input.files[0]);
        }
      },
      // Upload Image 
      showGallary(event,key,sort_order) {
        const form = event.target;
        const file = event.target.files[0];
        const fd = new FormData();
        fd.append('image', file);
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
                // this.galleryPreview = e.target.result;
                $('.imgGallary' + key).attr('src', e.target.result);
                uploadFile(fd).then(response => {
                  if(response.success == true){
                    // create data
                    let gImage = response.data.image_url;
                    Vue.set(this.gallery, key, {image: gImage, sort_order:sort_order})
                    // $('.g_imageGallary' + key).val(gImage);
                    // this.$refs['g_imageGallary' + key][0]['value'] = gImage;
                    // this.gallery.push({
                    //   image:gImage
                    // });
                    // this.gallery.splice(key, 1);
                  }else{
                    alert("Error while trying to upload file!")
                  }
                }).catch(e => {
                    alert("Error while trying to upload file!")
                    // this.errors.push(e)
                }); 
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
          // General
          this.formData.image = response['data']['image'];
          this.imagePreview = response['data']['image'];
          this.formData.name = response['general']['name'];
          this.formData.description = response['general']['description'];
          this.formData.meta_title = response['general']['meta_title'];
          this.formData.meta_description = response['general']['meta_description'];
          this.formData.meta_keyword = response['general']['meta_keyword'];
          // Data
          this.formData.model = response['data']['model'];
          this.formData.sku = response['data']['sku'];
          this.formData.manufacturer_id = response['data']['manufacturer_id'];
          this.formData.location = response['data']['location'];
          this.formData.price = response['data']['price'];
          this.formData.tax_class_id = response['data']['tax_class_id'];
          this.formData.quantity = response['data']['quantity'];
          this.formData.minimum = response['data']['minimum'];
          this.formData.substract = response['data']['substract'];
          this.formData.stock_status_id = response['data']['stock_status_id'];
          this.formData.shipping = response['data']['shipping'];
          this.formData.date_available = response['data']['date_available'];
          this.formData.sort_order = response['data']['sort_order'];
          this.formData.status = response['data']['status'];
          this.formData.category = response['links']['category'];
          this.formData.filter = response['links']['filter'];
          this.gallery = response['gallery'];
          this.formData.related_product = response['links']['related_product'];
          this.formData.store = response['links']['store'];
          this.formData.carrier = response['links']['carrier'];
          // shipping
          this.formData.length = response['data']['length'];
          this.formData.width = response['data']['width'];
          this.formData.height = response['data']['height'];
          this.formData.length_class_id = response['data']['length_class_id'];
          this.formData.weight = response['data']['weight'];
          this.formData.weight_class_id = response['data']['weight_class_id'];
          this.attribute = response['links']['attributes'];
          this.discount = response['discount'];
          this.special = response['special'];
          Flash.setLoading(false);
        })
      },
      getCustomerGroup() {
        fetchCustomerGroupList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['customer_group_id'],'name':response['data'][x]['name']}
            this.customerGroup.push(data)
          }
        })
      },
      getStockStatus(){
        fetchStockStatusList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['stock_status_id'],'name':response['data'][x]['name']};
            this.stockStatus.push(data);
          }
        })
      },
      getTaxClass(){
        fetchTaxClassList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['tax_class_id'],'name':response['data'][x]['title']};
            this.taxClass.push(data);
          }
        })
      },
      getAttribute(){
        fetchAttributeList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['attribute_id'],'name':response['data'][x]['name']};
            this.attributeData.push(data);
          }
        })
      },
      getWeightClass(){
        fetchWeightClassList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['weight_class_id'],'name':response['data'][x]['title']};
            this.weightClass.push(data);
          }
        })
      },
      getLengthClass(){
        fetchLengthClassList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['length_class_id'],'name':response['data'][x]['title']};
            this.lengthClass.push(data);
          }
        })
      },
      getProduct(){
        fetchProductList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'product_id':response['data'][x]['product_id'],'name':response['data'][x]['product_name']};
            this.product.push(data);
          }
        })
      },
      getCarrier(){
        fetchCarrierList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'carrier_id':response['data'][x]['carrier_id'],'name':response['data'][x]['name']};
            this.carrier.push(data);
          }
        })
      },
      getManufacturer(){
        fetchManufacturerList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['manufacturer_id'],'name':response['data'][x]['name']};
            this.manufacturer.push(data);
          }
        })
      },
      getCategory(){
        fetchCategoryList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'category_id':response['data'][x]['category_id'],'name':response['data'][x]['name']};
            this.category.push(data);
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
      getFilter(){
        fetchFilterList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'filter_id':response['data'][x]['filter_id'],'name':response['data'][x]['name']};
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
          // attribute #####
          let _attribute_id = $('input[name="attribute_id[]"]').length;
          for(let i = 0 ; i <= _attribute_id - 1; i++){
            let _attribute_id = this.$refs['attribute'+i][0]['value'];
            let _text = this.$refs['text'+i][0]['value'];
            let _attribute = {
                        "attribute_id":""+_attribute_id+"",
                        "text":""+_text+""
                      };
            this.attributeArr.push(_attribute);
          }
          this.formData.attribute = this.attributeArr;
          // discount product #####
          let _d_customer_group_id = $('input[name="d_customer_group_id[]"]').length;
          for(let i = 0 ; i <= _d_customer_group_id - 1; i++){
            let _d_customer_group_id = this.$refs['d_customer_group_id'+i][0]['value'];
            let _d_quantity = this.$refs['d_quantity' + i][0]['value'];
            let _d_priority = this.$refs['d_priority' + i][0]['value'];
            let _d_price = this.$refs['d_price' + i][0]['value'];
            let _d_start_date = this.$refs['d_start_date' + i][0]['value'];
            let _d_end_date = this.$refs['d_end_date' + i][0]['value'];

            let _discount = {
                        "customer_group_id":""+_d_customer_group_id+"",
                        "quantity":""+_d_quantity+"",
                        "priority":""+_d_priority+"",
                        "price":""+_d_price+"",
                        "date_start": ""+_d_start_date+"",
                        "date_end": ""+_d_end_date+"",
                      };
            this.discountArr.push(_discount);
          }
          this.formData.discount = this.discountArr;
          // image gallery ########
          let _imageGallary = $('input[name="imageGallary[]"]').length;
          for(let i = 0 ; i <= _imageGallary - 1; i++){
            let _image = this.$refs['g_imageGallary' + i][0]['value'];
            let _sort_order = this.$refs['g_sort_order' + i][0]['value']?this.$refs['g_sort_order' + i][0]['value']:0;
            var _gallery = {
                        "image":""+_image+"",
                        "sort_order":""+_sort_order+""
                      };
            this.galleryArr.push(_gallery);
          }
          this.formData.gallery = this.galleryArr;

          // special product #####
          let _s_customer_group_id = $('input[name="s_customer_group_id[]"]').length;
          for(let i = 0 ; i <= _s_customer_group_id - 1; i++){
            let _s_customer_group_id = this.$refs['s_customer_group_id'+i][0]['value'];
            let _s_priority = this.$refs['s_priority' + i][0]['value'];
            let _s_price = this.$refs['s_price' + i][0]['value'];
            let _s_start_date = this.$refs['s_start_date' + i][0]['value'];
            let _s_end_date = this.$refs['s_end_date' + i][0]['value'];

            let _special = {
                        "customer_group_id":""+_s_customer_group_id+"",
                        "priority":""+_s_priority+"",
                        "price":""+_s_price+"",
                        "date_start": ""+_s_start_date+"",
                        "date_end": ""+_s_end_date+"",
                      };
            this.specialArr.push(_special);
          }
          this.formData.special = this.specialArr;

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
                // this.initInsertElastic(response);
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
                // this.initInsertElastic(response);
                // this.clear();
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
        this.attributeArr = [];
        this.discountArr = [];
        this.galleryArr = [];
        this.specialArr = [];
      }
    }
  };
</script>