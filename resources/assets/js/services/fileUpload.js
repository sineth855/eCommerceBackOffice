import axios from 'axios'
import Flash from './flash'
var url = '/api/file_upload';
// fetch data
export function uploadFile(formData) {
	return axios.post(url,formData)
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