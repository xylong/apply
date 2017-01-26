/**
 * 检查手机号
 * @param  {string||integer} data 手机号
 * @return {boolean}
 */
function checkPhone(data) {
	return /^((\(\d{2,3}\))|(\d{3}\-))?13\d{9}$/.test(data);
}