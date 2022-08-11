function isStringNullOrWhiteSpace(str) {
    return str === undefined || str === null
        || typeof str !== 'string'
        || str.match(/^ *$/) !== null;
}

export { isStringNullOrWhiteSpace }
