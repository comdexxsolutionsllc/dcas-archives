# Set AIM Configuration Variables here
<?php

# Server target destination.  You probably want to leave this as it is.
$this->urlString = "https://secure.authorize.net/gateway/transact.dll";

# Your AIM login
$this->login = "changethis";

# Your Authorize.net Transaction Key  (n.b. this is very different from
# a "transaction ID").
$this->tran_key = "changethis";

# Protocol field Delimiter.  This is only used to decipher responses, it
# is not sent in requests.  Therefore, it must be set to your Authorize.net
# "Default Field Separator" setting.
$this->pdelimiter = "|";

# If, for some reason, you use a "Field Encapsulation Character".
#$this->pencap = "*";

# Client will consider it an error if the response contains fewer than this
# number of fields.
$this->pminfields = 10;

# Authorize.net calls this "Transaction Version".  I only know that 3.1 
# works, so I suggest you set it to 3.1.
$this->pversion = 3.1;

# I doubt this client will work if you have relay true.
$this->prelay_response = false;

# If this is true, the request will really go to Authorize.net, but
# Authorize.net only pretend to apply the charge (the RR text and
# confirmation emails will indicate test mode).
$this->test_request = true;

return true;
?>
