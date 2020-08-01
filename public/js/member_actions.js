let editMemberForm = document.getElementById('edit-member-form');
let addMemberForm = document.getElementById('add-member-form');

document.getElementById('add-member-btn').addEventListener('click', () => {
  addMemberForm.style.display = "block";
  if (editMemberForm !== null) editMemberForm.style.display = "none";
});

document.getElementById('cancel-edit-member').addEventListener('click', () => {
  addMemberForm.style.display = "none";
  if (editMemberForm !== null) editMemberForm.style.display = "none";
});