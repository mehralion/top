/**
 * Created by ice on 30.04.2016.
 */
var trans=[];
var snart=[];
for(var i=0x410;i<=0x44F;i++)
{
    trans[i]=i-0x350;
    snart[i-0x350] = i;
}
trans[0x401]= 0xA8;
trans[0x451]= 0xB8;
snart[0xA8] = 0x401;
snart[0xB8] = 0x451;
window.urlencode = function(str)
{
    var ret=[];
    for(var i=0;i<str.length;i++)
    {
        var n=str.charCodeAt(i);
        if(typeof trans[n]!='undefined')
            n = trans[n];
        if (n <= 0xFF)
            ret.push(n);
    }

    return window.escape(String.fromCharCode.apply(null,ret));
}
window.urldecode = function(str)
{
    var ret=[];
    str = unescape(str);
    for(var i=0;i<str.length;i++)
    {
        var n=str.charCodeAt(i);
        if(typeof snart[n]!='undefined')
            n = snart[n];
        ret.push(n);
    }

    return String.fromCharCode.apply(null,ret);
}