from Crypto.PublicKey import RSA
from hashlib import sha3_256
#python3 -m pip install pycryptodome
pair = RSA.generate(bits=2048);


#Public Key Values
n = pair.n;
e = pair.e;
#Private Key Values
n = pair.n;
d = pair.d;

#print(f"Public Key values:\nn = {n}\ne = {e}");
#print(f"Private Key values:\nn = {n}\nd = {d}");


original_msg = b"Super Secret Bank Info";

msg_hash = int.from_bytes(sha3_256(original_msg).digest());



#Equation is signature = message ^ d % n
#Pow's function definition is pow(int value_to_raise,int power,(optional) int value_to_modulus)
signature = pow(msg_hash,d,n);


#To decode it's m = s ^ e % n
decoded_signature = pow(signature,e,n);
print(f"Decoded hash from signature is: {hex(decoded_signature)}")
print(f"Is the signature valid: {'Yes' if msg_hash == decoded_signature  else 'No'}")


#Replace n with a random number (e.g. the Public key has been tampered with)
n = 1429009142019250953120951209512029511249129812498162489162498162491249812498124986115;

decoded_signature = pow(signature,e,n)
print(f"Decoded hash from signature is: {hex(decoded_signature)}")
print(f"Is the signature valid: {'Yes' if msg_hash == decoded_signature  else 'No'}")



