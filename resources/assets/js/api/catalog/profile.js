import axios from 'axios'
import {globalUrl} from '~/config/config'
import Flash from '~/services/flash'
const configUrl = globalUrl();
var url = '/api/user';

// fetch data
export function fetchProfile() {
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
