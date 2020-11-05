// Check if the objects have the same numbers of properties.
// Check if the objects have the same values.
var object1 = {
	name: 'cristina',
	lastname: 'rojas'
} 
 
var object2 = {
	name: 'cristina',
	lastname: 'rojas'
}
 
function compareTo(a, b){
	// Obtainging all the objects properties.
	var aProperties = Object.getOwnPropertyNames(a); 
	var bProperties = Object.getOwnPropertyNames(b); 
 
	console.log(aProperties.length); // 2 properties
	console.log(bProperties.length); // 1 propertie
 
	// If the number of properties are diferents then the objects are no equals.
	if (aProperties.length != bProperties.length) {
		return false;
	} 
 
	// If the objects have same numbers of properties 
	// We need to check if the properties values are the same
	for (var i = 0; i < aProperties.length; i++) {
		var saveNameProperty = aProperties[i]; // The name of the property name, lastname.
 
		if ( a[saveNameProperty] !== b[saveNameProperty]) { // The value of the property cristina, rojas.
			return false;
		}
	}
 
	return true;
}
 
checkObjectValues(object1, object2);