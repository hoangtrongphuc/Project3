;(function(window, undefined) {
    var consts = new Uint32Array([
            0xd76aa478, 0xe8c7b756, 0x242070db, 0xc1bdceee,
            0xf57c0faf, 0x4787c62a, 0xa8304613, 0xfd469501,
            0x698098d8, 0x8b44f7af, 0xffff5bb1, 0x895cd7be,
            0x6b901122, 0xfd987193, 0xa679438e, 0x49b40821,
            0xf61e2562, 0xc040b340, 0x265e5a51, 0xe9b6c7aa,
            0xd62f105d, 0x02441453, 0xd8a1e681, 0xe7d3fbc8,
            0x21e1cde6, 0xc33707d6, 0xf4d50d87, 0x455a14ed,
            0xa9e3e905, 0xfcefa3f8, 0x676f02d9, 0x8d2a4c8a,
            0xfffa3942, 0x8771f681, 0x6d9d6122, 0xfde5380c,
            0xa4beea44, 0x4bdecfa9, 0xf6bb4b60, 0xbebfbc70,
            0x289b7ec6, 0xeaa127fa, 0xd4ef3085, 0x04881d05,
            0xd9d4d039, 0xe6db99e5, 0x1fa27cf8, 0xc4ac5665,
            0xf4292244, 0x432aff97, 0xab9423a7, 0xfc93a039,
            0x655b59c3, 0x8f0ccc92, 0xffeff47d, 0x85845dd1,
            0x6fa87e4f, 0xfe2ce6e0, 0xa3014314, 0x4e0811a1,
            0xf7537e82, 0xbd3af235, 0x2ad7d2bb, 0xeb86d391 
        ]),
        shifts = new Uint8Array([
            7, 12, 17, 22, 7, 12, 17, 22, 7, 12, 17, 22, 7, 12, 17, 22,
            5,  9, 14, 20, 5,  9, 14, 20, 5,  9, 14, 20, 5,  9, 14, 20,
            4, 11, 16, 23, 4, 11, 16, 23, 4, 11, 16, 23, 4, 11, 16, 23,
            6, 10, 15, 21, 6, 10, 15, 21, 6, 10, 15, 21, 6, 10, 15, 21
        ]),
        initial = new Uint32Array([
            0x67452301,
            0xefcdab89,
            0x98badcfe,
            0x10325476
        ]);


    function processChunks(data, initial, shifts, contst) {
        var chunkCount = (data.byteLength * 8) / 512,
            currentChunk = 0,
            currentChunkOffset = 0,
            chunkInitial = new Uint32Array(initial), /* a0, b0, c0, d0 */
            digestBuffers = new Uint32Array(4), /* A, B, C, D */
            chunkBuffers = new Uint32Array(data.buffer), /* M[i] (0 <= i < 16) */
            tempBuffer = new Uint32Array(1), /* F */
            tempIndex  = new Uint8Array(1), /* g */
            tempD = new Uint32Array(1),
            leftRotate = function (data, amount) {
                var rotated = ((data << amount) | (data >>> (32 - amount))) >>> 0;
                return rotated;
            },
            i;

        /* Process each chunk */
        while(currentChunk < chunkCount)
        {
            /* Initialize A,B,C and D */
            digestBuffers.set(chunkInitial, 0);

            for(i = 0 ; i < 64 ; ++i)
            {
                if( i < 16 ) {
                    tempBuffer[0] = (digestBuffers[1] & digestBuffers[2]) | ((~digestBuffers[1]) & digestBuffers[3]);
                    tempIndex[0] = i;
                } else if (i < 32) {
                    tempBuffer[0] = (digestBuffers[3] & digestBuffers[1]) | ((~digestBuffers[3]) & digestBuffers[2]); 
                    tempIndex[0] = (5 * i + 1) % 16; 
                } else if (i < 48) {
                    tempBuffer[0] = (digestBuffers[1] ^ digestBuffers[2]) ^ digestBuffers[3];
                    tempIndex[0] = (3 * i + 5) % 16;
                } else {
                    tempBuffer[0] = digestBuffers[2] ^ (digestBuffers[1] | (~digestBuffers[3]));
                    tempIndex[0] = (7 * i) % 16;
                }

                tempD[0] = digestBuffers[3];
                digestBuffers[3] = digestBuffers[2];
                digestBuffers[2] = digestBuffers[1];
                digestBuffers[1] = digestBuffers[1] + leftRotate(digestBuffers[0] + tempBuffer[0] + consts[i] + chunkBuffers[tempIndex[0]], shifts[i]);
                digestBuffers[0] = tempD[0];
            }

            chunkInitial[0] += digestBuffers[0];
            chunkInitial[1] += digestBuffers[1];
            chunkInitial[2] += digestBuffers[2];
            chunkInitial[3] += digestBuffers[3];

            ++currentChunk;
            currentChunkOffset += 64; /* Move to the next 512bit (64 byte) chunk */
        }

        return new Uint8Array(chunkInitial.buffer);
    }

    /* Expose the MD5 digest function
     *
     * @param value An Uint8Array with the data to obtatin the digest for.
     *
     * @return An Uint8Array with the MD5 digest of the data */
    window.md5 = function(value) {
        var byteLength = value.byteLength,
            bitLength = byteLength * 8,
            paddedBitLength = 0,
            zeroPadLength = 0,
            padding, i,
            paddedData,
            digest;

        /* Calculate the amount of padding needed */
        /* 1 bit padding, followed by as many zeroes as needed to reach 
         * a bit length of 448 (mod 512) */
        paddedBitLength = bitLength + 1;
        if(paddedBitLength % 512 < 448) {
            zeroPadLength += 448 - (paddedBitLength % 512);
        } else if(paddedBitLength % 512 > 448) {
            zeroPadLength += 448 + (512 - (paddedBitLength % 512));
        }

        /* Initialize the padding buffer */
        padding = new Uint8Array((zeroPadLength + 1) / 8);
        padding[0] = 0x80;
        for(i = 1 ; i < padding.length ; ++i) {
            padding[i] = 0;
        }

        /* Append padding to original data (and the 64 bytes for the length) */
        paddedData = new Uint8Array(byteLength + padding.length + 8);
        paddedData.set(value, 0);
        paddedData.set(padding, byteLength);

        /* Append the length *in bits* of the initial message, modulo 2^64 to the data 
         * FIXME: currently, there is no way to even represent a number 
         * larger than 32bit without resorting to something like BigNumber,
         * so here just assume the length is < 2^64. If the actual data 
         * is larger it will produce wrong results (assuming that you 
         * managed to load that amount of data in the first place into 
         * your script. */
        paddedData.set([
                ((bitLength & 0x000000ff) >>> 0), 
                ((bitLength & 0x0000ff00) >>> 8),
                ((bitLength & 0x00ff0000) >>> 16),
                ((bitLength & 0xff000000) >>> 24)
                ], byteLength + padding.length);

        /* Process each 512bit chunk */
        return processChunks(paddedData, initial, shifts, consts);
    };

}(window));
