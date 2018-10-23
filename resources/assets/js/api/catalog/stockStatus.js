import axios from 'axios'
import config from '~/config/config'
import Flash from '~/services/flash'
var url = '/api/stock_status';

// fetch data
export function fetchStockStatusList() {
	return axios.get(url)
	.then(response => {
		if(response.data.success==true){
			Flash.setLoading(false)
			return response['data'];
		}else{
			return response['data'];
		}
	})
	.catch(e => {
		this.errors.push(e)
	})
}

// fetch data
export function fetchList() {
	return axios.get(url)
	.then(response => {
		if(response.data.success==true){
			Flash.setLoading(false)
			return response['data'];
		}else{
			return response['data'];
		}
	})
	.catch(e => {
		this.errors.push(e)
	})
}
// create
export function createData(data) {
	return axios.post(url,data
	).then((response)=>{
		if(response.data.success==true){
			Flash.setLoading(false)
			return response['data'];
		}else{
			return response['data'];
		}
	})
	.catch((err) => {
		if(err.response.status === 422) {
			return err.response.message
		}
	})
}
// view edit
export function editData(param) {
	return axios.get(url+'/'+param+'/edit')
	.then(response => {
		if(response.data.success==true){
			Flash.setLoading(false)
			return response['data'];
		}else{
			return response['data'];
		}
	})
	.catch(e => {
		this.errors.push(e)
	})
}
// update
export function updateData(data,id) {
	return axios.put(url+'/'+id,data)
	.then((response)=>{
		if(response.data.success==true){
			Flash.setLoading(false)
			return response['data'];
		}else{
			return response['data'];
		}
	})
	.catch((err) => {
		if(err.response.status === 422) {
			return err.response.message
		}
	})
}
// destroy
export function deleteData(id) {
	return axios.delete(url+'/'+id)
	.then((response)=>{
		if(response.data.success==true){
			Flash.setLoading(false)
			return response['data'];
		}else{
			return response['data'];
		}
	})
	.catch((err) => {
		if(err.response.status === 422) {
			return err.response.message
		}
	})
}