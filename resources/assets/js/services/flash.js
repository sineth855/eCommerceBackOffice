import axios from 'axios'
export default{
	state: {
		success: null,
		elasticdata : '',
		fetchInfo : '',
		fetchStore : '',
		error: null,
		StateData:[],
		loading:false
	},
	setLoading(boolen){
		this.state.loading = boolen
	},
	setStateData(message){
		this.state.StateData = message
	},
	setState(message){
		this.state.elasticdata = message
	},
	fetchInformation(id){
		axios.get('/api/information/'+id).then(response => this.state.fetchInfo=response.data)
	},
	fetchStore(data){
		this.state.fetchStore = data
	},
	setSuccess(message){
		this.state.success = message

		setTimeout(() => {
			this.removeSuccess() 
		},3000)
	},
	setError(message){
		this.state.error = message 
		setTimeout(() => {
			this.removeError() 
		},3000)
	},
	removeSuccess(message){
		this.state.success = null
	},
	removeError(message){
		this.state.error = null
	}
}