# eset
Easy License ESET Antivirus

## Requests
* Setting Request

	get: `{api.domain.com}/eset/setting?apikey=your-api-key`

* Validation Request

	get: `{api.domain.com}/eset/validate?apikey=your-api-key & username=your-username & password=your-password & device_id=your-device-id & operator=your-product` 

* Device Request

	post: `{api.domain.com}/eset/device?apikey=your-api-key & username=your-username & password=your-password & device_id=your-device-id & operator=your-product & params[0][your-key]=your-value & params[1][your-key]=your-value`


## Responses
* Setting Response

		{
			'username'=> 'your-username',
			'password'=> 'your-password',
			'file_server'=> 'your-file-server',
			'ftp' => {
			    'server'=> 'ftp-host-name',
			    'path'=> 'ftp-host-path',
			},
			'ftp2' => {
			    'username'=> 'ftp2-username',
			    'password'=> 'ftp2-password',
			} 
		} 

* Validation Response

		{
			'username'  => 'license-username',
			'password'  => 'license-password', 
			'expiresOn' => 'expiration-date',
			'startedAt' => 'start-date', 
			'daysLeft'  => 'days-left',
			'users'     => 'license-users',
			'inUse'     => 'in-use-users',
			'fileServer'=> 'your-file-server',
			'failServer'=> 'your-fail-server',
			'servers'   => 'array-of-avaialble-servers', 
			'serials'   => 'array-of-user-serials', 
		}

* Device Response

		{ 
			'expiresOn' => 'expiration-date', 
			'daysLeft'  => 'days-left', 
			'inUse'     => 'in-use-users', 
			'available' => 'available-user', 
		}

## Http response codes

400: Invalid operator

401: Invalid `apikey` or `domain` or `accept-value`

403: Invalid serial. users is fully filled

404: Invalid credit data

410: Expiration
