function createXMLHTTPObject()
{
    if (typeof XMLHttpRequest != 'undefined')
    {
        return new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
        var axo = [
            'Microsoft.XmlHttp',
            'MSXML2.XmlHttp',
            'MSXML2.XmlHttp.3.0',
            'MSXML2.XmlHttp.4.0',
            'MSXML2.XmlHttp.5.0'
        ];

        for (var i = axo.length - 1; i > -1; i--)
        {
            try
            {
                httpObj = new ActiveXObject(axo[i]);
                return httpObj;
            }
            catch(e) {}
        }
    }

    throw new Error('XMLHTTP not supported');
}

