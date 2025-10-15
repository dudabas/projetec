
const conteudosOriginais = {};

function getElementos(tipo) {
    const lista = document.getElementById(`lista-${tipo}`);
    const areaEdicao = document.getElementById(`area-${tipo}`);
    const btnEditar = document.getElementById(`btn-editar-${tipo}`);
    const btnSalvar = document.getElementById(`btn-salvar-${tipo}`);
    const btnCancelar = document.getElementById(`btn-cancelar-${tipo}`);
    return { lista, areaEdicao, btnEditar, btnSalvar, btnCancelar };
}

function habilitarEdicao(tipo) {
    const { lista, areaEdicao, btnEditar, btnSalvar, btnCancelar } = getElementos(tipo);

    if (!lista || !areaEdicao) return;

    lista.style.display = 'none';
    areaEdicao.style.display = 'block';

    let textoLista = '';
    lista.querySelectorAll('li').forEach(item => {
        textoLista += item.textContent.replace(/^-/g, '').trim() + '\n';
    });
    areaEdicao.value = textoLista.trim();

    btnEditar.style.display = 'none';
    if (btnSalvar) btnSalvar.style.display = 'inline-block';
    if (btnCancelar) btnCancelar.style.display = 'inline-block';
    areaEdicao.focus();
}

function salvarEdicao(tipo) {
    const { lista, areaEdicao, btnEditar, btnSalvar, btnCancelar } = getElementos(tipo);

    if (!lista || !areaEdicao) return;

    const novoTexto = areaEdicao.value;
    const novosItens = novoTexto
        .split('\n')
        .filter(line => line.trim() !== '')
        .map(line => `<li>- ${line.trim()}</li>`)
        .join('');

    lista.innerHTML = novosItens;
    conteudosOriginais[tipo] = lista.innerHTML;
    
    const dadosParaEnviar = {
        card_tipo: tipo,
        novo_conteudo_bruto: novoTexto,
    };

    console.log(`Dados prontos para enviar para o backend da categoria ${tipo}:`, dadosParaEnviar);
    
    lista.style.display = 'block';
    areaEdicao.style.display = 'none';
    btnEditar.style.display = 'inline-block';
    if (btnSalvar) btnSalvar.style.display = 'none';
    if (btnCancelar) btnCancelar.style.display = 'none';
}

function cancelarEdicao(tipo) {
    const { lista, areaEdicao, btnEditar, btnSalvar, btnCancelar } = getElementos(tipo);

    if (!lista || !areaEdicao) return;

    lista.innerHTML = conteudosOriginais[tipo];

    areaEdicao.style.display = 'none';
    lista.style.display = 'block';
    btnEditar.style.display = 'inline-block';
    if (btnSalvar) btnSalvar.style.display = 'none';
    if (btnCancelar) btnCancelar.style.display = 'none';
}

document.addEventListener('DOMContentLoaded', () => {
    ['carnes', 'acompanhamentos', 'saladas'].forEach(tipo => {
        const { lista } = getElementos(tipo);
        if (lista) {
            conteudosOriginais[tipo] = lista.innerHTML;
        }
    });
});