import sys, json

def calcular_desconto(preco, desconto):
    
    preco_final = preco - (preco * desconto / 100)
    return preco_final

if __name__ == '__main__':
    if len(sys.argv) < 3:
        print(json.dumps({"error": "Parâmetros insuficientes"}))
        sys.exit(1)
    try:
        preco =    float(sys.argv[1])
        desconto = float(sys.argv[2])
    except ValueError:
        print(json.dumps(({"error": "Parâmetros inválidos"})))
        sys.exit(1)
        
    resultado = {
        "preco_original": preco,
        "desconto": desconto,
        "preco_final": round(calcular_desconto(preco, desconto), 2)
    }
    print(json.dumps(resultado))