import axios from 'axios'
import config from '~/config/config'
import Flash from '~/services/flash'

// fetch data
export function globalUrl() {
	const url = "http://localhost:8000";
	return url;
}

export function resellerUrl() {
	const url = "http://localhost:8000";
	return url;
}

// fetch data
export function elastickUrl() {
	const url = "http://localhost:9200";
	return url;
}