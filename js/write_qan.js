document.addEventListener(`DOMContentLoaded`, () => {
  const mode = '<?= $mode ?>';
  const btn_ok = document.querySelector('#btn_ok');
  const subjectInput = document.querySelector('#input_subject');
  const contentTextarea = document.querySelector('#textarea_content');
  btn_ok.addEventListener("click", () => {
    if (!subjectInput.value.trim()) {
      alert('제목을 입력하세요!');
      subjectInput.focus();
      return;
    }

    if (!contentTextarea.value.trim()) {
      alert('내용을 입력하세요!');
      contentTextarea.focus();
      return;
    }

    switch (mode) {
      case 'response':
        console.log('<?= $origin_content ?>');
        document.write_qna.action = "dml_qna.php?mode=r_insert&num=<?= $num ?>&question=<?= $origin_content ?>";
        break;

      case 'update':
        document.write_qna.action = "dml_qna.php?mode=update&num=<?= $num ?>&hit=<?= $hit ?>&m_type=<?= $member_type ?>";
        break;
    }
    document.write_qna.submit();
  });
});